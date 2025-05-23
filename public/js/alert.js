import Swal from "sweetalert2";
export async function sweetAlert() {
    return await Swal.fire({
        title: "Vuoi cancellare l'utente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Conferma",
        cancelButtonText: "Annulla"
    });
}
