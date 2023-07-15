$('.delete-button').click(function(e) {
    e.preventDefault();
    const mailAddress = $(this).closest('tr').find('.mail-address').text().trim();
    console.log(mailAddress);
    const next = confirm(`${mailAddress}を削除してよろしいですか？`);

    if (next) {
        $(this).closest('tr').find('.delete-form').submit();
    }
});