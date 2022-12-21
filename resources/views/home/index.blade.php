@extends('templates.layout')
@section('content')
  @csrf
    <div class="container">
      <div class="d-flex justify-content-center mt-5 mb-4">
        <a class="me-1"><img src="{{ asset('assets/img/logowikrama.png') }}" alt="" width="80px"></a>
        <a><img src="{{ asset('assets/img/logorpl.png') }}" alt="" width="80px"></a>
      </div>
      <div class="text-center">
        <p class="display-6" data-aos="zoom-in" data-aos-easing="ease-in-back"
         data-aos-duration="1000">Welcome to PPLG Laptop Lending!</p>
        <p class="lead"><?= date('l, d M Y');?></p>
        <hr class="mt-4 mb-3">
      </div>
      <div class="d-flex">
        <table id="table1" class="table d-flex justify-content-center">
          <tbody>
            <tr>
              <td><i class="bi bi-box-arrow-in-left" style="font-size: 42px"></i></td>
              <td>
                <div class="fw-bold mt-1">Returned</div>
                <div>Total laptop who returned this day</div>
              </td>
              <td>
                <div class="fs-5 fw-bold mt-3 ms-3">
                  {{ $laptops->where('return_date', "=", $hari)->count() }}
                </div>
              </td>
              {{-- <td>
                {{ \Carbon\Carbon::now()->format('j M') }}
              </td> --}}
            </tr>
          </tbody>
        </table>
        <table id="table1" class="table d-flex justify-content-center">
          <tbody>
            <tr>
              <td><i class="bi bi-box-arrow-right" style="font-size: 40px"></i></td>
              <td>
                <div class="fw-bold mt-1">Loaned</div>
                <div>Total laptop who loaned this day</div>
              </td>
              <td>
                <div class="fs-5 fw-bold mt-3 ms-3">
                 {{   $laptops->where('return_date', "=", null)->where('date', '=', $hari)->count();  }}
                </div>
              </td>
              {{-- <td>
                {{ \Carbon\Carbon::now()->format('j M') }}
              </td> --}}
            </tr>
          </tbody>
        </table>
      </div>
      <div class="d-flex mt-3 g-5 ms-5 justify-content-between">
        <div class="ms-5 ps-5"></div>
        <div class="fw-bold fs-3" id="textlisttoday">List Today</div>
        <div class="d-flex me-5">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Request a Laptop Loan</button>
        </div>
      </div>
      <div class="modal" id="exampleModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Please Fill Out This Form</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="/store">
                @csrf
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" value="{{ old('name') }}">     
                  </div>
                  <div class="mb-3">
                    <label class="form-label">NIS</label>
                    <input name="nis" type="number" class="form-control">
                    {{-- @error('nis')
                    <p class="text-danger fw-bold">{{ $message }}</p>
                    @enderror --}}
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Rayon</label>
                    <select name="rayon" class="form-select" aria-label="Default select example">
                      <option selected hidden>Pilih Rayon</option>
                      <option value="Wikrama 1">Wikrama 1</option>
                      <option value="Wikrama 2">Wikrama 2</option>
                      <option value="Wikrama 3">Wikrama 3</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Teacher Name</label>
                    <input name="teacher" type="text" class="form-control">
                  </div>  
                  <div class="mb-3">
                    <label class="form-label">Purpose</label>
                    <input name="purposes" type="text" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input name="description" type="text" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input name="date" type="date" class="form-control">
                  </div>                     
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <table class="table my-4 mx-3">
        <thead>
          <tr>
            <th scope="col">NIS</th>
            <th scope="col">NAME</th>
            <th scope="col">REGION</th>
            <th scope="col">PURPOSES</th>
            <th scope="col">DESCRIPTION</th>
            <th scope="col">DATE</th>
            <th scope="col">RETURN DATE</th>
            <th scope="col">TEACHER</th>
            <th scope="col">ACTION</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($laptops as $item)  
          @if ($item['date'] == $hari || $item['return_date'] == null || $item['return_date'] == $hari)    
          <tr>
            <th>{{ $item['nis'] }}</th>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['rayon'] }}</td>
            <td>{{ $item['purposes'] }}</td>
            <td>{{ $item['description'] }}</td>
            <td>{{ Carbon\Carbon::parse($item['date'])->format('j F Y') }}</td>
            @if ($item['return_date']==null)
              <td class="text-warning">
                Belum dikembalikan
              </td>                                
            @else 
              <td>
                {{ Carbon\Carbon::parse($item['return_date'])->format('j F Y') }}
              </td>              
            @endif
            <td>{{ $item['teacher'] }}</td>
            <td class="d-flex">
              @if ($item['return_date'] == null)
                <form action="/update/{{ $item['id'] }}" method="post">
                  @csrf
                    @method('patch')
                    <button type="submit" class="btn btn-success me-1" style="border-radius: 12px"><i class="bi bi-check-lg"></i></button>
                </form>
              @endif                  
              <form action="/destroy/{{ $item['id'] }}" method="post">
                @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-danger" style="border-radius: 12px"><i class="bi bi-x-lg"></i></button>
              </form>
            </td>
          </tr>
          @endif
          @endforeach
        </tbody>
      </table>
    </div>
@endsection
