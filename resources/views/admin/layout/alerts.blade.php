<style>
.alert-floating {
    position: fixed;
    top: 80px;
    right: 20px;
    z-index: 9999;

    min-width: 250px;
    max-width: 350px;

    box-shadow: 0 4px 12px rgba(0,0,0,0.15);

    transform: translateX(120%);
    opacity: 0;
    transition: all 0.4s ease;
}

/* masuk */
.alert-floating.show {
    transform: translateX(0);
    opacity: 1;
}

/* keluar */
.alert-floating.hide {
    transform: translateX(120%);
    opacity: 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const alertBox = document.getElementById('alertPopup');

    if(alertBox){

        // muncul
        setTimeout(() => {
            alertBox.classList.add('show');
        }, 100);

        // hilang
        setTimeout(() => {
            alertBox.classList.remove('show');
            alertBox.classList.add('hide');
        }, 3000);

    }

});
</script>