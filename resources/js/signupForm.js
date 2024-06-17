window.addEventListener("submit", function (event) {
    const form = event.target;
    if (!form.classList.contains("tpnw-getactive-eventgrid__form")) return;

    event.preventDefault();
    let url = new URL(form.action).toString();
    url.
    window.location.href = url.toString();
});
