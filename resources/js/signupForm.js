window.addEventListener("submit", function (event) {
    const form = event.target;
    if (!form.classList.contains("tpnw-getactive-eventgrid__form")) return;

    event.preventDefault();
    let url = new URL(form.action).toString();
    let formData = new FormData(form);
    let events = formData.getAll("events[]").join(",");
    if (events.length === 0) {
        alert("Please select at least one event to sign up for.");
        return;
    }
    url = url.replace("PLACEHOLDER", events);
    window.location.href = url.toString();
});
