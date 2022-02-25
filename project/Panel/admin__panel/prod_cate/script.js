


//--------------------- Sort tables (ASC - DEC) ------------------------------


const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

const comparer = (idx, asc) => (a, b) => ((v1, v2) => 
    v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
    )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));


document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
//    var array_up = document.getElementById('hidden1');
//    var array_down = document.getElementById('hidden2');
  const table = th.closest('table'); 
  //console.log(table)
  const tbody = table.querySelector('tbody');
  Array.from(tbody.querySelectorAll('tr'))

    .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
    .forEach(tr => tbody.appendChild(tr)) 
    // if (this.asc){
    //     array_up.style.visibility = "visible";
    //     array_down.style.visibility = "hidden";
    //     console.log('fir')
    // }
    // else{
    //     array_up.style.visibility = "hidden";
    //     array_down.style.visibility = "visible";
    //     console.log('sec')
    // }
       
    
} ) ));
