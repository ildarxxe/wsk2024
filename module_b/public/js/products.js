document.addEventListener("DOMContentLoaded", () => {
    const changeStatusBtn = document.querySelectorAll(".change_status_btn");
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    changeStatusBtn.forEach(btn => {
        btn.addEventListener("click", async () => {
            const GTIN = btn.dataset.id
            const data = await fetch(`/products/${GTIN}/change-status`, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                }
            }).then(r => {
                if (r.message === "") {
                    const element = `<div class="errors"><p>${r.error}</p></div>`
                    document.querySelector(".errors_wrapper").innerHTML += element
                } else {
                    window.location.reload()
                }
            })
                .catch(e => console.log(e))
        })
    })

    const rows = document.querySelectorAll(".product")
    rows.forEach(row => {
        row.addEventListener("click", (e) => {
            if (!e.target.closest("button") || !e.target.closest("a")) {
                const GTIN = row.dataset.id;
                window.location.href = `/products/${GTIN}`
            }
        })
    })
})
