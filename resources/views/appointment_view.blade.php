<x-Header/>

<h2>Appointment Form</h2>
    {!! Form::open(['route' => 'time_slot.store', 'method' => 'POST', 'id' => 'add_slot_form']) !!}

    <div class="row">
      <div class="mb-3 mt-3 col-3">
        <label for="doctor_id">Doctor Id:</label>

        {{ Form::select('doctor_id', $doctors, '', ['class' => 'form-control']) }}
        @if ($errors->has('doctor_id'))
        <div class="error">{{ $errors->first('doctor_id') }}</div>
        @endif
      </div>
    </div>

    <div class="row">
      <div class="col-1"><button class="btn btn-sm btn-light border border-round date-previous" data-type="prev" type="button">Previous</button></div>
      <div class="col-1">
        <div class="date-box show-date">{{date("d-M")}}</div>
        <div class="data-ajax-date"></div>
      </div>
      <div class="col-1"><button class="btn btn-sm btn-light border border-round date-next" data-type="next" type="button">Next</button></div>
    </div>

  <!-- Modal -->
  <div class="modal fade bookappoitmentModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="alert text-danger m-0 text-center p-0 validation_error"
                                style="display:none">
                                <ul></ul>
                            </div>
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Book Appoitment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Please Enter Name">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="example@gmail.com">
              <input type="hidden" readonly id="doct_orid" name="doctor_id">
              <input type="hidden" readonly id="startT_ime" name="start_time">
            </div>
            <div class="mb-3">
              <label for="contact_number" class="form-label">Contact</label>
              <input type="text" class="form-control" id="contact_number" placeholder="+91 9999999999">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
          <button type="button" class="btn btn-primary bookAppoitment" id="bookAppoitments">Save</button>
        </div>
      </div>
    </div>
  </div>


<x-Footer />
