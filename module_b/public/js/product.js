document.addEventListener("DOMContentLoaded", () => {
    const edit_btn = document.querySelector(".edit")
    const edit_form = document.querySelector(".edit_form")

    edit_btn.addEventListener("click", () => {
        edit_form.classList.toggle("hidden")
    })

    const del_prod = document.getElementById("del_prod")
    const del_img = document.getElementById("del_img")

    del_prod.addEventListener("click", async () => {
        const GTIN = del_prod.dataset.gtin
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute("content")

        await fetch(`/products/${GTIN}/delete`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrf,
            }
        }).then(r => window.location.href = "/products")
    })

    del_img.addEventListener("click", async () => {
        const GTIN = del_img.dataset.gtin
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute("content")

        await fetch(`/products/${GTIN}/delete-image`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrf,
            }
        }).then(r => window.location.reload())
    })
})
