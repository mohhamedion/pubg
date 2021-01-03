// $('.question').click(event => {
//     let self = $(event.target);
//     if (self.prop('className') === 'question-text') {
//         self = self.parent();
//     }
//     if (self.prop('className') === 'question-answer') {
//         return false;
//     }

//     let answer = self.find('.question-answer');
//     if (!answer.is(':visible')) {
//         self.addClass('active');
//         answer.slideDown(200);
//     } else {
//         self.removeClass('active');
//         answer.slideUp(200);
//     }
// });


var acc = document.getElementsByClassName("question");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}