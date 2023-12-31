<html>
<head>
   <style>
      table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    td, th {
        padding: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width:300px!important;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Expand on hover */
    td:hover {
        white-space: normal!important;
        overflow: visible!important;
        text-overflow: inherit!important;

    }
   </style>
</head>
<body>

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
                  arrayToTable(value);
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

      function arrayToTable(array) {
          // Create a table element
          const table = document.createElement('table');

          // Create the header row
          const headerRow = table.insertRow(0);
          for (const key in array[0]) {
              const th = document.createElement('th');
              th.textContent = key;
              headerRow.appendChild(th);
          }

          // Create rows and cells
          array.forEach(obj => {
              const row = table.insertRow();
              for (const key in obj) {
                  const cell = row.insertCell();
                  cell.textContent = stringifyObject(obj[key]);
              }
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
 </body>
</html>