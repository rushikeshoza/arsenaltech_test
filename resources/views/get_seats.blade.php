@extends('master')
@section('title', 'Arsenaltech Test')
@section('content')

<style type="text/css">
    .selected {
        background-color: cyan;
    }
    
    .cancel-selected {
        background-color: red !important;
    }
    
    .not-available {
        background-color: grey;
    }
</style>

<div class="row">
    <div class="col-md-11">
        <center><h1>Book Seats</h1></center>
        @php
            $sessionMsg = '';
            $seatNo     = 0;
        @endphp
        @if(Session::has('status'))
            @php $sessionMsg = Session::get('status'); @endphp
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hovered">
                    @for ($i = 1; $i < 7; $i++)
                        <tr>
                            @for ($j = 1; $j < 6; $j++)
                                @php
                                    $seatNo++;
                                    $iconCls = "ic-outline-event-seat";
                                    $class   = '';
                                @endphp
                                <td>
                                    @if (in_array($seatNo, $allBookings))
                                        @php $iconCls = "ic-baseline-event-seat"; $class = 'not-available'; @endphp
                                    @endif
                                    
                                    <center>
                                        <div class="book-seat {{ $class }}" data-seat-no="{{ $seatNo }}">
                                            <span class="iconify" data-icon="{{ $iconCls }}" data-inline="false" style="font-size: 38px; cursor: pointer;"></span>
                                        </div>
                                    </center>
                                </td>
                            @endfor
                        </tr>
                    @endfor
                    <tr><td colspan="5"></td></tr>
                    <tr><td colspan="5"><center><i class="fa fa-arrow-down"></i> Screen This Side <i class="fa fa-arrow-down"></i></center></td></tr>
                </table>
            </div>
        </div>
        
        <center>
            <button type="button" class="btn btn-info book-now-btn" data-toggle="modal" data-target="#customerInfoModal" style="display: none;">Book Now!</button>
            <button type="button" class="btn btn-info cancel-now-btn" data-toggle="modal" data-target="#cancelBooking" style="display: none;">Cancel</button>
        </center>
    </div>
    <div class="col-md-2"></div>
</div>

<!-- Customer Info Modal -->
<div id="customerInfoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Booking Information</h4>
            </div>
            <div class="modal-body">
                
                <!-- Form Start -->
                <form class="form-horizontal" action="{{ route('book_seats') }}" method="POST">
                    <fieldset>
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label class="col-md-8 control-label seat-text"></label>
                        </div>
                        
                        <!-- Text input -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">Full Name</label>
                            <div class="col-md-6">
                                <input id="name" name="name" type="text" placeholder="Rushikesh Oza" class="form-control input-md" required>
                                <span class="help-block">Enter your full name</span>
                            </div>
                        </div>
                        
                        <!-- Text input -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="email">Email</label>
                            <div class="col-md-6">
                                <input id="email" name="email" type="email" placeholder="abc@def.com" class="form-control input-md" required>
                                <span class="help-block">Enter your Email-id</span>
                            </div>
                        </div>
                        
                        <!-- Prepended text -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="contact_no">Contact No</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">+91</span>
                                    <input id="contact_no" name="contact_no" class="form-control" placeholder="contact no" type="tel" pattern="^\d{10}$" required>
                                </div>
                                <p class="help-block">Enter your phone number without any special character or space</p>
                            </div>
                        </div>
                        
                        <!-- Hidden Field -->
                        <input type="hidden" name="selectedSeats" id="selectedSeats">
                    </fieldset>
                    
                    <center>
                        <button type="submit" class="btn btn-info book-seat-btn">Book</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </center>
                </form>
                <!-- Form End -->
                
            </div>
        </div>
    </div>
</div>

<!-- Customer Info Modal -->
<div id="cancelBooking" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cancel Booking</h4>
            </div>
            <div class="modal-body">
                {{ csrf_field() }}
                
                <!-- Text input -->
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-8 control-label seat-text"></label>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">Email</label>
                            <div class="col-md-6">
                                <input id="cancel_email" name="cancel_email" type="text" placeholder="Email" class="form-control input-md" required>
                                <span class="help-block">Enter your email id</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">Confirmation No</label>
                            <div class="col-md-6">
                                <input id="confirmation_no" name="confirmation_no" type="text" placeholder="Confirmation No" class="form-control input-md" required>
                                <span class="help-block">Enter your confirmation number</span>
                            </div>
                        </div>
                    </fieldset>
                </form>
                
                <center>
                    <button type="button" class="btn btn-info cancel-booking">Cancel</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </center>
            </div>
        </div>
    </div>
</div>

@endsection

@section('jsContent')
    <script type="text/javascript">
        window.sessionMsg = "{{ $sessionMsg }}";
        window.cancelUrl = "{{ route('cancel_booking') }}";
    </script>
    <script src="{{ asset('js/seat_bookings.js') }}"></script>
@endsection
