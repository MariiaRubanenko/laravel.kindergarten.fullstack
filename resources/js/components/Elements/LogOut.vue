<template>
    <div class="logOut">
        <span class="material-icons" style="font-size: 3.5rem" @click="logout"
            >logout</span
        >
    </div>
</template>

<script>
import { logout } from "@/api/request";

export default {
    data() {
        return {
            error: "Error",
        };
    },
    methods: {
        async logout() {
            try {
                await logout();
            } catch (error) {
                console.error("Error during logout:", error);
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.logOut {
    color: var(--green-dark);
    text-decoration: none;
    display: block;
    transition: 0.2s ease-in-out;

    &:hover {
        .material-icons {
            color: var(--green-light);
        }
    }
}
</style>
