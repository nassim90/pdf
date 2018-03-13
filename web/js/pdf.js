function HTMLtoPDF(){
var pdf = new jsPDF('p', 'pt', 'a4');
 pdf.addHTML($('#gsr')[0], function () {
     pdf.save('Test.pdf');
 });		
}


