@extends('frontend.pages.portal.welcome')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" />

<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
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
counter=0;
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
    const thead = document.createElement('thead');
    // Create the header row using all keys in the array
    const headerRow = thead.insertRow(0);
    var headCounter=0;

    // Create the header row using all keys in the array
    allKeysArray.forEach(key => {
        headCounter++;
        const th = document.createElement('th');
        if(headCounter>=4)th.className="expandable";
        th.textContent = key;
        headerRow.appendChild(th);
    });
    table.appendChild(thead)
    const tbody = document.createElement('tbody');

    // Create rows and cells
    array.forEach(obj => {
        const row = tbody.insertRow();
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
    });

    table.appendChild(tbody)
    table.id='myTable'+counter++;
    var container = document.getElementById("container");
    if(counter==1){
            var h5=document.createElement('h5');
            h5.textContent = "User API key";
            var label=document.createElement('label');
            label.textContent = "LIVE";
            var checkbox=document.createElement('input');
            checkbox.type = "checkbox";
            checkbox.value = "1";
            checkbox.checked = array[0]['live']==0?false:true;
            checkbox.setAttribute('data-toggle',"toggle");
            checkbox.id="toggle-one";
            label.appendChild(checkbox);
            container.appendChild(document.createElement('br'));
            container.appendChild(label);
            container.appendChild(h5);
            checkbox.change = function() {
                var isChecked = this.checked;
                var token = '{{ csrf_token() }}'; // Assuming you're using Blade for CSRF token

                // Prepare data to send
                var data = {
                    _token: token,
                    live: isChecked ? 1 : 0 // Convert boolean to 1 or 0
                };

                // Prepare Ajax request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/setUserLiveStatus', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', token); // Set CSRF token in header

                // Send data as JSON
                xhr.send(JSON.stringify(data));

                // Handle response
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log('Request successful');
                        // Handle successful response here
                    } else {
                        console.error('Request failed');
                        // Handle failed response here\
                        checkbox.checked = !isChecked;
                    }
                };
            };

        }else{
        var h5=document.createElement('h5');
        h5.textContent = "Merchant(s) API key(s)"
        container.appendChild(h5);
    }
    container.appendChild(table);
    $('#myTable'+(counter-1)).DataTable({
    "columnDefs": [
        {
            "targets": ".expandable", // Target columns by class name
            "className": "none"
        }
    ],
    "scrollX": true // Enable horizontal scrolling if needed
});
    // createTotal(array.length);
}

      function createButton(href,text) {
          var buttonContainer = document.getElementById("buttons");
          const button = document.createElement('button');
          button.textContent = text;
          button.onclick=function(){location.href = `${href}`;};
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
         try{
         createForm(jsonData);
         }catch(e){
         var container = document.getElementById("container");
        container.innerHTML='';
         createForm({json:[jsonData]});

         }
         let next=`{!!$next??0!!}`;
         let prev=`{!!$prev??0!!}`;
         if(next!=`0`){
            createButton(next,"Next")
         }
         if(prev!=`0`){
            createButton(prev,"Prev")
         }

   </script>
@endsection
