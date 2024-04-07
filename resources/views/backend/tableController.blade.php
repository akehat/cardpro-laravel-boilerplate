@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <x-backend.card>
        <x-slot name="header">
            @lang('Welcome! check columns to remove, :Name', ['name' => $logged_in_user->name])
        </x-slot>

        <x-slot name="body">
                <div class="table-container">
                    @foreach($tables as $tableName => $columnsSet)
                    @php
                        $columns=$columnsSet[0];
                        $removed=$columnsSet[1];
                        if($removed=="[]")$removed=[];
                    @endphp
                    <div class="column">
                        <h3>{{ str_replace("_"," ",$tableName) }}</h3>
                        <form class="updateForm" method="POST" data-table="{{ $tableName }}" action="{{ route('admin.table.update') }}">
                            @csrf
                            <div class="column-checkboxes">
                                @foreach($columns as $column)
                                <label class="checkbox-container">
                                    <input type="checkbox" name="{{ $tableName }}[]" value="{{ $column }}" {{in_array($column,$removed)?'checked':''}}>
                                    <span class="checkmark"></span>
                                    {{ $column }}
                                </label>
                                @endforeach
                            </div>
                            <button type="submit" class="submitBtn">Submit</button>
                        </form>
                    </div>
                    @endforeach
                </div>

                <script>
                    // AJAX request to handle form submission
                    document.querySelectorAll('.updateForm').forEach(form => {
                        form.addEventListener('submit', function(event) {
                            event.preventDefault();
                            var formData = new FormData(this);

                            // Check if any checkboxes are checked
                            var checked = false;
                            form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                                if (checkbox.checked) {
                                    checked = true;
                                }
                            });

                            // If none are checked, add an empty array for the table name
                            if (!checked) {
                                formData.append(this.getAttribute('data-table'), []);
                            }

                            // Sending AJAX request
                            axios.post(this.action, formData)
                                .then(function(response) {
                                    console.log(response.data);
                                    // Handle success response if needed
                                })
                                .catch(function(error) {
                                    console.error(error);
                                    // Handle error response if needed
                                });
                        });
                    });
                </script>


<style>
    .table-container{
        display: flex;
        flex-wrap: wrap;
    }
    .column-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Adjust the gap between columns as needed */
    }
    h3{
        text-transform: capitalize;
    }
    .column {
        background-color: #f9f9f9; /* Background color of each column */
        padding: 10px;
        border-radius: 5px;
        margin:3px;
    }

    .checkbox-container {
        display: block;
    }
    input[type=checkbox]{
        transform: scale(1.5);
    }
    label{
        font-weight:bold;
        /* font-size: 16px; */
    }
    /* Add your checkbox styling here */

    #submitBtn {
        margin-top: 20px; /* Adjust the margin as needed */
    }
    .column {
            background-color: #ffffff; /* Background color of each column */
            padding: 20px;
            border-radius: 15px;
            margin: 10px;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.9);
            transition: transform 0.3s;
        }

        .column:hover {
            transform: translateY(-5px);
        }

        .column h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .column-checkboxes {
            margin-bottom: 20px;
        }

        .checkbox-container {
            display: block;
            margin-bottom: 5px;
        }

        .checkbox-container input {
            margin-right: 10px;
        }

        .submitBtn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submitBtn:hover {
            background-color: #0056b3;
        }

        .submitBtn.submitting {
            background-color: #6c757d; /* Change color while submitting */
            cursor: not-allowed;
        }
</style>
        </x-slot>
    </x-backend.card>
@endsection
