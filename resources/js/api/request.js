import axios from "axios";

export const getToken = async () => {
    try {
        await axios.get(
            "https://e321-178-150-111-49.ngrok-free.app/sanctum/csrf-cookie"
        );
    } catch (error) {
        console.error(error);
    }

    return getCookie("XSRF-TOKEN");
};

function getCookie(name) {
    const cookie = document.cookie
        .split("; ")
        .find((item) => item.startsWith(`${name}=`));
    if (!cookie) {
        return null;
    }
    return decodeURIComponent(cookie.split("=")[1]);
}

export function getCookies(name) {
    try {
        const cookie = document.cookie
            .split("; ")
            .find((item) => item.startsWith(`${name}=`));
        if (!cookie) {
            return null;
        }
        return decodeURIComponent(cookie.split("=")[1]);
    } catch (error) {
        console.error(error);
        throw error;
    }
}

import router from "@/router/router.js";

export async function logout() {
    redirectToLogIn();
    try {
        const csrfToken = getCookies("XSRF-TOKEN");
        const response = await axios.delete("logout", {
            headers: {
                "X-XSRF-Token": csrfToken,
            },
        });
        console.log("Logout successfully:", response);
    } catch (error) {
        console.error("Error logout:", error);
    }
}

function redirectToLogIn() {
    localStorage.removeItem("userAuthenticated");
    localStorage.removeItem("userRole");
    localStorage.removeItem("userRoleId");
    localStorage.removeItem("groupId");
    router.push("/login");
}
