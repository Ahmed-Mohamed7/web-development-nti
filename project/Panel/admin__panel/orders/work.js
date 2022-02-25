// details = document.getElementById('details')
// list = document.getElementById('sublist');
// window.onload(list.style.visibility = "hidden");
// // function listappear(){
// //     list
// // }


// --------------------------- search function
  function myFunction() {
    // Declare variables
    var input, filter, table1, tr1, td, i, txtValue, found = 0;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table1 = document.getElementsByTagName("table");
    //console.log(table1);
    tr = document.getElementsByTagName('tr')
    console.log(tr.length)
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 1; i < tr.length; i++) {
        let td2;
        td = tr[i].getElementsByTagName("td")[0]; //ID
        td2 = tr[i].getElementsByTagName("td")[1]; //customer name
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (td2) {
                txtValue2 = td2.textContent || td2.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                    found += 1;
                }

            }

        }
    }
    console.log(found)
    if (found == tr.length - 1) {
        alert('no result')
    }
}




//-------------------------- sort ---------------------------------
const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
    v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
)(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));


document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {

    const table = th.closest('table');

    const tbody = table.querySelector('tbody');
    Array.from(tbody.querySelectorAll('tr'))

        .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
        .forEach(tr => tbody.appendChild(tr))

})));