@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->

            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Subscribers</h6>
                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search here" class="form-control" style="width: 200px;">

                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    
                                    {{-- <th scope="col">Names</th> --}}
                                    <th scope="col">Subscriber Email</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subscribers as $rs)
                                <tr>

                                    {{-- <td>{{ $rs->fName}} {{ $rs->lName }}</td> --}}
                                    <td>{{ $rs->email }}</td>
                                    <td>{{ $rs->created_at }}</td>
                                    <td>
                                        <div class="btn-btn-group ">
                                            <a type="button" href="{{ route('destroySub', $rs->id) }}"
                                                class="btn btn-danger text-black" onclick="return confirm('Are you sure to delete this item?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            {{ $subscribers->links('pagination::simple-bootstrap-4', ['style' => 'margin-top: 20px;']) }}


                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content End -->

        <script>
            function searchTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                table = document.getElementsByClassName("table")[0];
                tr = table.getElementsByTagName("tr");
        
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[2]; // Change index to match the column you want to search
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>

        @include('admin.includes.footer')

 @endsection