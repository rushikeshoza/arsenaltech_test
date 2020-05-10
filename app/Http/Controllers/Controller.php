<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\SeatBookings;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * <Get all the seats which are booked from the database>
     * @param  : [void]
     * @return : [view] [<View for the seat booking>]
     * @author : Rushikesh Oza <rushikesh.oza27@gmail.com> | 09 May 2020 (Saturday)
     */
    public function getSeats()
    {
        $allBookings = SeatBookings::get()->pluck('seat_no', 'id')->toArray();
        return view('get_seats', compact('allBookings'));
    }
    
    /**
     * <Method will be used to book the seats>
     * @param  : [obj] [$request] [<Request Params Object>]
     * @return : [view] [<It will return to booking page view>]
     * @author : Rushikesh Oza <rushikesh.oza27@gmail.com> | 10 May 2020 (Sunday)
     */
    public function bookSeats(Request $request)
    {
        $postData      = $request->all();
        $selectedSeats = explode(',', $postData['selectedSeats']);
        
        // check if the selected seats are present or not
        if (empty($selectedSeats)) {
            $request->session()->flash('status', 'You must select atleast one seat for the booking...!!!');
            return redirect()->route('get_seats');
        }
        
        // check if the selected seats are availabe or not for the booking
        $isBooked = SeatBookings::whereIn('seat_no', $selectedSeats)->first();
        if (!empty($isBooked)) {
            $request->session()->flash('status', 'Someone is in hurry for the bookings, please try another seats...!!!');
            return redirect()->route('get_seats');
        }
        
        $confirmationNo = $this->getConfirmationNo();
        
        if (!empty($confirmationNo)) {
            foreach ($selectedSeats as $key => $seatNo) {
                $dataToInsert[$key] = [
                    'seat_no'         => $seatNo,
                    'name'            => $postData['name'],
                    'email'           => $postData['email'],
                    'contact_no'      => $postData['contact_no'],
                    'confirmation_no' => $confirmationNo
                ];
            }
            
            SeatBookings::insert($dataToInsert);
            
            $mailText = 'Thank you for booking with us. This is the confirmation number for the future conversation : ' . $confirmationNo;
            
            Mail::raw($mailText, function ($message) use ($postData) {
                $message->to($postData['email'])->subject('Booking Confirmed...!!!');
            });
            
            $request->session()->flash('status', 'Seats booked successfully...!!!');
        } else {
            $request->session()->flash('status', 'Something went wrong...!!! Please try again...!!!');
        }
        
        return redirect()->route('get_seats');
    }
    
    /**
     * <This function will help to check confirmation number is available or not>
     * @param  : [void]
     * @return : [str] [<Available confirmation string>]
     * @author : Rushikesh Oza <rushikesh.oza27@gmail.com> | 10 May 2020 (Sunday)
     */
    public function getConfirmationNo()
    {
        $str = random_str(12);
        
        if (!empty($str)) {
            $isAvail = SeatBookings::where('confirmation_no', $str)->first();
            if (!empty($isAvail)) {
                return $this->getConfirmationNo();
            } else {
                return $str;
            }
        }
    }
    
    /**
     * <This function will check and remove booking from the data base if found entry>
     * @param  : [obj] [$request] [<Request Param Object>]
     * @return : [void]
     * @author : Rushikesh Oza <rushikesh.oza27@gmail.com> | 10 May 2020 (Sunday)
     */
    public function cancelBooking(Request $request)
    {
        if (!empty($request->all()) && !empty($request->get('cancelSelectedSeatNo', []))) {
            foreach ($request->get('cancelSelectedSeatNo', []) as $cancelSeatNo) {
                $getSeat = SeatBookings::where(['email' => $request->get('cancel_email', ''), 'confirmation_no' => $request->get('confirmation_no', ''), 'seat_no' => $cancelSeatNo])->first();
                
                if (empty($getSeat)) {
                    $request->session()->flash('status', 'Wrong email or confirmation number. Please try again...!!!');
                } else {
                    $getSeat->delete();
                    $request->session()->flash('status', 'Booking cancelled successfully. We are sorry to see you go...!!!');
                }
            }
        }
    }
}
