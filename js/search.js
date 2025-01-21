function myFunction() {
    var input, filter, table, tr, td, i, txtValue, count, counter=0;
    input = document.getElementById("myInput");
    count = document.getElementById("record-count");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.querySelectorAll("tbody tr"); //todo: test it in other browsers
    let matchFound = false;
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    matchFound = true;
                }
            }
        }
        if (matchFound) {
            tr[i].style.display = "";
            counter++;
        } else {
            // debugger
            tr[i].style.display = "none";
        }
        matchFound = false;
        count.innerText = `Total: ${counter}`
    }
}

document(myFunction());

// setTimeout(myFunction, 500)