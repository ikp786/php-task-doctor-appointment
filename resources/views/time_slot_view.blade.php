<x-Header/>

<h2>Stacked form</h2>
    {!! Form::open(['route' => 'time_slot.store', 'method' => 'POST', 'id' => 'add_slot_form']) !!}

    <div class="row">
    <div class="mb-3 mt-3">
      <label for="doctor_id">Doctor Id:</label>
      {{ Form::number('doctor_id', '',['id' => 'doctor_id', 'class' =>'form-control'])    }}
      {{-- <input type="number" class="form-control" id="doctor_id" placeholder="Enter Doctor Id" name="doctor_id"> --}}
      @if ($errors->has('doctor_id'))
      <div class="error">{{ $errors->first('doctor_id') }}</div>
       @endif
    </div>

    <div class="mb-3">
      <label for="slot_date">Slot Date:</label>
      {{ Form::text('slot_date', '',['id' => 'slot_date', 'class' =>'form-control'])}}
      @if ($errors->has('slot_date'))
      <div class="error">{{ $errors->first('slot_date') }}</div>
      @endif
    </div>

    <div class="mb-3">
        <label for="start_time">Start Time:</label>
        {{ Form::time('start_time', '',['id' => 'start_time', 'class' =>'form-control'])    }}

      @if ($errors->has('start_time'))
      <div class="error">{{ $errors->first('start_time') }}</div>
      @endif
    </div>

      <div class="mb-3">
        <label for="end_time">End Time:</label>
        {{ Form::time('end_time', '',['id' => 'end_time', 'class' =>'form-control'])    }}
        @if ($errors->has('end_time'))
      <div class="error">{{ $errors->first('end_time') }}</div>
     @endif
      </div>

      <div class="mb-3">
        <label for="slot">Slot:</label>
        <select class="form-control"  name="slot" id="slot">
            <option value="15">15 Minutes</option>
            <option value="30">30 Minutes</option>
            <option value="45">45 Minutes</option>
            <option value="60">60 Minutes</option>
            @if ($errors->has('slot'))
            <div class="error">{{ $errors->first('slot') }}</div>
        @endif
        </select>
    </div>
  </div>    

  {{ Form::button('Submit', ['class' => 'btn btn-primary', 'type' => 'submit','id' => 'submit_slot_form']) }}
    {!! Form::close() !!}

<x-Footer />