@extends('frontend.pages.portal.welcome')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
    table, th, td {
      border-collapse: collapse;
  }
  th:first-of-type{
      border-radius: 25px 0px 0px 0px;
  }
  th:last-of-type{
      border-radius: 0px 25px 0px 0px;
  }

  th{
      text-align: center!important;
      align-items: center;
  }
  td, th {
      padding: 10px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width:400px!important;
      min-width:400px!important;
      width:400px!important;
  }

  table {
      border-collapse: collapse;
      width: 100%;
      border-radius: 25px;
  }

  th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
  }

  th {
      border: none;
      background-color: #f2f2f2;
  }

  /* Expand on hover */
  td:hover {
      word-wrap: wrap;
      word-break: break-word;
      white-space: normal!important;
      overflow: visible!important;

      /* text-overflow: inherit!important; */

  }
 </style>

   <div id="container"></div>
   <div id="total"></div>
   <div id="limit"></div>
   <div id="buttons"></div>
   <script>

      // Function to convert JSON data to HTML table
      function createForm(data) {
          var keys = Object.keys(data);
          var values = Object.values(data);
          for (let i = 0; i < values.length; i++) {
              var value = values[i];
              if (typeof value === 'object' && !Array.isArray(value)) {
                  createForm(value);
              } else if (Array.isArray(value)) {
                  arrayToTable2(value);
              } else {
                  // Modified stringify for objects
                  const stringValue = stringifyObject(value);
                  console.log(keys[i] + ": " + stringValue);
                  if(keys[i]=="next_cursor"){
                    createButton(value)
                  }
                  if(keys[i]=="limit"){
                    createLimit(value)
                  }
                  if(keys[i]=="total"){
                    createTotal(total)
                  }
              }
          }
      }

    //   function arrayToTable(array) {
    //       // Create a table element
    //       const table = document.createElement('table');

    //       // Create the header row
    //       const headerRow = table.insertRow(0);
    //       for (const key in array[0]) {
    //           const th = document.createElement('th');
    //           th.textContent = key;
    //           headerRow.appendChild(th);
    //       }

    //       // Create rows and cells
    //       array.forEach(obj => {
    //           const row = table.insertRow();
    //           for (const key in obj) {
    //               const cell = row.insertCell();
    //               cell.textContent = stringifyObject(obj[key]);
    //           }
    //       });
    //       var container = document.getElementById("container");
    //       container.appendChild(table);
    //       createTotal(array.length);
    //   }
    function arrayToTable2(array) {
    // Create a Set of all unique keys in the array
    const allKeysSet = new Set();

    // Iterate through each object in the array and add its keys to the Set
    array.forEach(obj => {
        Object.keys(obj).forEach(key => {
            allKeysSet.add(key);
        });
    });

    // Convert the Set back to an array
    const allKeysArray = Array.from(allKeysSet);

    // Create a table element
    const table = document.createElement('table');

    // Create the header row using all keys in the array
    const headerRow = table.insertRow(0);
    allKeysArray.forEach(key => {
        const th = document.createElement('th');
        th.textContent = key;
        headerRow.appendChild(th);
    });
    const th = document.createElement('th');
        th.textContent = "Actions";
        headerRow.appendChild(th);
    // Create rows and cells
    array.forEach(obj => {
        const row = table.insertRow();
        allKeysArray.forEach(key => {
            const cell = row.insertCell();
            if(key=="id"){
                var link= document.createElement('a');
                var getUrl = (window.location+'').split("?")[0];
                getUrl = getUrl.endsWith("ies")?getUrl.substring(0,getUrl.length - 3) +'ys':getUrl;
                var Url = getUrl.substring(0,getUrl.length - 1) +"/"+ obj[key];
                link.href=getUrl.endsWith(obj[key])?getUrl:Url;
                link.textContent=obj[key];
                cell.appendChild(link);
            }else{
                cell.textContent = stringifyObject(obj[key]);
            }
        });
        const cell = row.insertCell();
        var button = document.createElement('button');
        button.textContent="return";
        button.onclick=function(){
            var confirmed = confirm("Are you sure you want to void the hold?");
            if (confirmed) {
            $.ajax({
            type: 'POST', // You can change the HTTP method as needed
            url: '{{url("returnHoldLive")}}', // Replace with your actual Laravel route
            data: {
                id: obj['id'],
                _token: '{{ csrf_token() }}' // Include Laravel CSRF token
            },
            success: function (data) {
                // Handle success, you can alert the user or perform other actions
                alert('message= ' + JSON.stringify(data));
            },
            error: function (xhr, status, error) {
                // Handle errors if needed
                console.error(xhr.responseText);
            },
            beforeSend: function (xhr) {
                // Set the CSRF token in the request header
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            }
        });
    }
        }
        cell.appendChild(button);
        button = document.createElement('button');
        button.textContent="Capture";
        button.onclick=function(){
            var amount = prompt("Please enter capture amount", obj['amount']);
            if (amount != null) {
            $.ajax({
            type: 'POST', // You can change the HTTP method as needed
            url: '{{url("captureHoldLive")}}', // Replace with your actual Laravel route
            data: {
                id: obj['id'],
                amount: amount,
                _token: '{{ csrf_token() }}' // Include Laravel CSRF token
            },
            success: function (data) {
                // Handle success, you can alert the user or perform other actions
                alert('message= ' + JSON.stringify(data));
            },
            error: function (xhr, status, error) {
                // Handle errors if needed
                console.error(xhr.responseText);
            },
            beforeSend: function (xhr) {
                // Set the CSRF token in the request header
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            }
        });
    }
        }
        cell.appendChild(button);
    });

    var container = document.getElementById("container");
    container.appendChild(table);
    createTotal(array.length);
}

      function createButton(buttonText) {
          var buttonContainer = document.getElementById("buttons");
          const button = document.createElement('button');
          let path = window.location.href.split('?')[0]
          button.textContent = `Next`;
          button.onclick=function(){location.href = `${path}?after_cursor=${buttonText}`;};
          buttonContainer.appendChild(button);
      }
      function createLimit(limitText) {
          var limitContainer = document.getElementById("limit");
          const limit = document.createElement('h5');
          limit.textContent = `Limit:${limitText}`;
          limitContainer.appendChild(limit);
      }
      function createTotal(totalText) {
          var totalContainer = document.getElementById("total");
          const total = document.createElement('h5');
          total.textContent = `Total:${totalText}`;
          totalContainer.innerHTML = "";
          totalContainer.appendChild(total);
      }
      // Custom stringify for objects
      function stringifyObject(obj) {
          if (typeof obj === 'object') {
            var returned=''
              return JSON.stringify(obj).replaceAll('}','').replaceAll('"','').replaceAll('{','').replaceAll(',','\n');
          }
          return obj;
      }
         // Sample JSON data
         let jsonData = JSON.parse(`{!!$json!!}`);
         createForm(jsonData);

   </script>
@endsection
