$(document).ready(function () {
    $('#dataTable').DataTable();
});
$(document).ready(function () {
    $('.myselect2').select2();
});
// increment decrecent
$(document).ready(function(){
    //increment
   
    $(document).on('click','.increment',function(){
        var quantityInput= $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.proId').val();
        var currentValue=parseInt(quantityInput.val());

        if(!isNaN(currentValue)){
            var qtyVal=currentValue+1;
            quantityInput.val(qtyVal);
            //console.log(qtyVal, productId);
            quantityIncDec(productId, qtyVal);
            
        }
    });
    //decrement
    $(document).on('click', '.decrement', function () {
        var quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.proId').val();
        var currentValue = parseInt(quantityInput.val());

        if (!isNaN(currentValue)&& currentValue>1) {
            var qtyVal = currentValue - 1;
            quantityInput.val(qtyVal);
            //console.log(qtyVal, productId);
            quantityIncDec(productId, qtyVal);
            
        }
    });

    function quantityIncDec(productId, qtyVal) {
        $.ajax({
            url: 'order_create/' + encodeURIComponent(qtyVal) + '/' + encodeURIComponent(productId),
            type: "POST",
            success: function (response) {
                var res=JSON.parse(response);
                console.log(res);
                if(res.status==200){
                    $('#productArea').load(' #productContent');
                    //window.location.reload();
                    //console.log(res.message);
                   Swal.fire({
                        position:"center",
                        icon:"success",
                       title: res.message,
                       showConfirmButton:false,
                       timer:1000
                   });
                
                    //alertify.success(res.message);
                }else{
                    //console.log(res.message);
                    $('#productArea').load(' #productContent');
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: res.message,
                        text:"something went wrong",
                        timer: 1000
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
            // success: function (response) {
            //     window.location.reload();
            //     console.log("Response: url exist", response);
            // },
            // error: function (xhr, status, error) {
            //     if (xhr.status === 404) {
            //         console.error("Url not exist 404", error);
            //     } else {
            //         console.error("Error occured:", status, error);
            //     }
            // }
        });

    }


    // function quantityIncDec(proId, qty) {
    //     $.ajax({
    //         type: "POST",
    //         url: "order_create",
    //         data: {
    //             'productIncDec': true,
    //             'product_id': proId,
    //             'quantity': qty
    //         },
    //         success: function (response) {
    //             var res = JSON.parse(response);
    //             if (res.status == 200) {
    //                 window.location.reload();
    //                 alertify.success(res.message);
    //             } else {
    //                 console.log(response);
    //                 alertify.error(res.message);
    //             }
    //         }
    //     });
    // }
    ///function for payment and phone
    $(document).on('click', '#processToPlace', function () {
        var payment_mode = $('#payment_mode').val();
        var cphone = $('#cphone').val();
        if (payment_mode == '') {
            Swal.fire("select Payment Mode", "Select your payment mode", "warning");
            return false;
        }
        if (cphone == '' && !$.isNumeric(cphone)) {
            Swal.fire("Enter Phone Number", "Enter valid Phone Number", "warning");
            return false;
        }
        
        var data = {
            'proceedToPlace': true,
            'cphone': cphone,
            'payment_mode': payment_mode,
        }
        $.ajax({
            url: 'order_payment/' + encodeURIComponent(payment_mode) + '/' + encodeURIComponent(cphone),
            type: 'POST',
            success:function(response){
                var res = JSON.parse(response);
                console.log(res);
               if(res.status==200){
                    window.location.href="order_summary";
               }
               if(res.status==404){
                    swal.fire({
                        title: res.message,
                        text: res.message,
                        icon:res.status_type,
                        showCancelButton:true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText:"Add Customer"
                    }).then((result)=>{
                        if(result.isConfirmed){
                            $('#c_phone').val(cphone);//add ph number to modal 
                            $('#addCustomerModal').modal('show');
                        }
                    });
               }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });


    });
    //add new customer to customer table
    $(document).on('click',"#saveCustomer",function(){
        var c_name = $('#c_name').val();
        var c_phone = $('#c_phone').val();
        var c_email = $('#c_email').val();
        if (c_name == '') {
            Swal.fire("please Enter name field", "", "warning");
            return false;
        }
        if (c_phone == '' && !$.isNumeric(c_phone)) {
            Swal.fire("Enter Phone Number", "Enter valid Phone Number", "warning");
            return false;
        }
        if (c_email == '') {
            Swal.fire("please Enter email field", "", "warning");
            return false;
        }
        $.ajax({
            url: 'order_payment_customer/',
            type:'post',
            data: {
                cname: c_name,
                cphone: c_phone,
                cemail: c_email
            },
            success:function(response){
                var res=JSON.parse(response);
                console.log(res);
                if(res.status==200){
                    swal.fire(res.message,res.message,res.status_type);
                    $('#addCustomerModal').modal('hide');
                }
                else if(res.status == 422){
                    swal.fire(res.message, res.message, res.status_type);
                }else{
                    swal.fire(res.message, res.message, res.status_type);
                }
            },
            error:function(xhr,status,error){
                console.error("AJAX ERROR",status,error);
            }
        });   
    });
    $(document).on('click','#saveOrder',function(){
        $.ajax({
            type:"POST",
            url:"order_save",
                success:function(response){
                var res=JSON.parse(response);
                console.log(res);
                if(res.status==200){
                    swal.fire(res.message, res.message, res.status_type);
                    $('#orderPlaceSuccessMessage').text(res.message);
                    $('#orderSuccessModal').modal('show')
                }else{
                    swal.fire(res.message, res.message, res.status_type);
                }
            
            },
            error: function (xhr, status, error) {
                console.error("AJAX ERROR", status, error);
            }

        });
    });
    
});
function printMyBillingArea() {
    divContents = document.getElementById("myBillingArea").innerHTML;
    var a = window.open('', '');
    a.document.write('<html><title>POS system</title>');
    a.document.write('<body style="font-family:cambia">');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print();

}  
// Extract jsPDF from window.jspdf
const { jsPDF } = window.jspdf;

// Create a new instance of jsPDF
const docPDF = new jsPDF();
function downloadPDF(invoiceNo) {
    // Select the HTML element you want to convert
    const elementHTML = document.querySelector("#myBillingArea");

    // Use jsPDF's html method
    docPDF.html(elementHTML, {
        callback: function (doc) {
            // Save the PDF with the given invoice number
            doc.save(invoiceNo + '.pdf');
        },
        x: 15,
        y: 15,
        width: 170,
        windowWidth: 650,
    });
}

