window.onload = function () {
    var open = document.getElementById('open-panel');
    var close = document.getElementById('close-panel');
    var panel = document.getElementById('panel');

    if (localStorage.getItem('panel-status') === 'opened') {
        open.style.display = 'none';
        close.style.display = 'block';
        panel.style.display = 'block';
    }

    function openPanel()
    {
        open.style.display = 'none';
        close.style.display = 'block';
        panel.style.display = 'block';
        localStorage.setItem('panel-status', 'opened');
    }

    function closePanel()
    {
        open.style.display = 'block';
        close.style.display = 'none';
        panel.style.display = 'none';
        localStorage.setItem('panel-status', 'closeds');
    }

    open.onclick = function () {
        openPanel();
    };

    close.onclick = function () {
        closePanel();
    };
};