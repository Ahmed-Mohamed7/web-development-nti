$(".delete").click(function () {
    let isbn = $(this).attr("data-id");
    $.ajax({
        url: "request_hander.php",
        type: "POST",
        data: {
            delete: 1,
            isbn: isbn,
        },
        success: function (data) {
            //    console.log(isbn);
            location.reload();
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
    });
});


var current_id = null;
var current_cell = null;
var current_index = null;
$('#Modal').on('shown.bs.modal', function () {
    $('#edit').trigger('focus')
})
$(".edit").click(function () {
    current_id = $(this).attr("data-id");
    current_index = $(this).attr("data-index");
    current_cell = ['isbn', 0];
    $.ajax({
        url: "request_hander.php",
        type: "POST",
        data: {
            get: 1,
            id: current_id,
            column: current_cell[0]
        },
        success: function (data) {
            $('#message-text').val(data);
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
    });
});
$("#SelectColumn").change(function () {
    current_cell = $("#SelectColumn").val().split(" ");
    $.ajax({
        url: "request_hander.php",
        type: "POST",
        data: {
            get: 1,
            id: current_id,
            column: current_cell[0]
        },
        success: function (data) {
            $('#message-text').val(data);
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
    });
});
$("#send").click(function () {
    var data = $('#message-text').val();
    var ok = true;
    $("#message-text").removeClass('is-invalid');
    if ($("#message-text").val().length === 0 || !$("#message-text").val().trim()) {
        $('#message-text').addClass('is-invalid');
        ok = false;
    }
    switch (current_cell[0]) {
        case 'isbn':
            data = '"' + data + '"';
            break;
        case 'title':
            data = '"' + data + '"';
            break;
        case 'description':
            data = '"' + data + '"';
            break;
        case 'published_format':
            data = '"' + data + '"';
            break;
        case 'image':
            data = '"' + data + '"';
            break;
        case 'language':
            data = '"' + data + '"';
            break;
    }
    if (ok)
        $.ajax({
            url: "request_hander.php",
            type: "POST",
            data: {
                set: 1,
                id: current_id,
                column: current_cell[0],
                data: data
            },
            success: function (data) {
                if (data == 1) {
                    alert('DB Error!');
                }
                else {
                    var myTable = document.getElementById('dataTable');
                    myTable.rows[current_index].cells[current_cell[1]].innerHTML = data.replace(/['"]+/g, '');
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
});



$(".add").click(function () {
    var ok = true;
    $("#isbn").removeClass('is-invalid');
    if ($("#isbn").val().length === 0 || !$("#isbn").val().trim()) {
        $('#isbn').addClass('is-invalid');
        ok = false;
    }
    $("#title").removeClass('is-invalid');
    if ($("#title").val().length === 0 || !$("#title").val().trim()) {
        $('#title').addClass('is-invalid');
        ok = false;
    }
    $("#description").removeClass('is-invalid');
    if ($("#description").val().length === 0 || !$("#description").val().trim()) {
        $('#description').addClass('is-invalid');
        ok = false;
    }
    $("#cat_id").removeClass('is-invalid');
    if ($("#cat_id").val().length === 0 || !$("#cat_id").val().trim()) {
        $('#cat_id').addClass('is-invalid');
        ok = false;
    }
    $("#author_id").removeClass('is-invalid');
    if ($("#author_id").val().length === 0 || !$("#author_id").val().trim()) {
        $('#author_id').addClass('is-invalid');
        ok = false;
    }
    $("#pub_house_id").removeClass('is-invalid');
    if ($("#pub_house_id").val().length === 0 || !$("#pub_house_id").val().trim()) {
        $('#pub_house_id').addClass('is-invalid');
        ok = false;
    }
    $("#img").removeClass('is-invalid');
    if ($("#img").val().length === 0 || !$("#img").val().trim()) {
        $('#img').addClass('is-invalid');
        ok = false;
    }
    $("#copies").removeClass('is-invalid');
    if ($("#copies").val().length === 0 || !$("#copies").val().trim()) {
        $('#copies').addClass('is-invalid');
        ok = false;
    }
    $("#price").removeClass('is-invalid');
    if ($("#price").val().length === 0 || !$("#price").val().trim()) {
        $('#price').addClass('is-invalid');
        ok = false;
    }
    $("#PubFormat").removeClass('is-invalid');
    if ($("#PubFormat").val().length === 0 || !$("#PubFormat").val().trim()) {
        $('#PubFormat').addClass('is-invalid');
        ok = false;
    }
    $("#lang").removeClass('is-invalid');
    if ($("#lang").val().length === 0 || !$("#lang").val().trim()) {
        $('#lang').addClass('is-invalid');
        ok = false;
    }

    let isbn = "'" + $("#isbn").val() + "'";
    let title = "'" + $("#title").val() + "'";
    let description = "'" + $("#description").val() + "'";
    let category_id = $("#cat_id").val();
    let author_id = $("#author_id").val();
    let publishing_house_id = $("#pub_house_id").val();
    let image = "'" + $("#img").val() + "'";
    let copies = $("#copies").val();
    let price = $("#price").val();
    let published_format = "'" + $("#PubFormat").val() + "'";
    let language = "'" + $("#lang").val() + "'";

    if (ok)
        $.ajax({
            url: "request_hander.php",
            type: "POST",
            data: {
                add: 1,
                isbn: isbn,
                title: title,
                author_id: author_id,
                category_id: category_id,
                description: description,
                price: price,
                image: image,
                publishing_house_id: publishing_house_id,
                published_format: published_format,
                copies: copies,
                language: language,
            },
            success: function (data) {
                // console.log(data);
                if (data == 0) {
                    alert('ISBN already exists!');
                }
                else if (data == 1) {
                    alert('Referential Error!');
                }
                else
                    location.reload();
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
});





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

//-------------------------- search -------------------
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
    for (i = 1; i < tr.length - 1; i++) {
        let td2;
        td = tr[i].getElementsByTagName("td")[0]; //ID
        td2 = tr[i].getElementsByTagName("td")[1]; //Title
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
    if (found == tr.length - 3) {
        alert('no result')
    }
}