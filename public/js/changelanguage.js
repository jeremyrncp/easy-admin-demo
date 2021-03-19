$(function() {
    $("#changeLanguage").change((event) => {
        const params = new URLSearchParams(window.location.search)
        params.set("locale", event.target.value)

        window.location.replace(window.location.pathname + "?" + params)
    })
})
