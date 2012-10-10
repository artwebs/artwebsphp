$(document).ready(function () {
$("#btnAlert").click(function ()
{ jAlert('Pushed the alert button', 'Alert Dialog'); });
$("#btnPrompt").click(function () {
jPrompt('Type some value:', '', 'Prompt Dialog', function (typedValue) {
if (typedValue) {
jAlert('You typed the following ' + typedValue);
}
});
});
});
