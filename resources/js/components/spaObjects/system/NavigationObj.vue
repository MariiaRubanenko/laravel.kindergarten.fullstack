<template>
    <aside :class="`${is_expanded ? 'is-expanded' : ''}`">
        <router-link to="/" class="logo" style="padding-left: 0">
            <img :src="logoURL" alt="logo" />
            <div v-if="is_expanded" class="logo-text">Happy Times</div>
        </router-link>

        <div class="menu-toggle-wrap">
            <button class="menu-toggle" @click="ToggleMenu">
                <span class="material-icons">keyboard_double_arrow_right</span>
            </button>
        </div>

        <h3 style="padding-left: 1rem">{{ $t("navigation.menu") }}</h3>

        <div
            v-if="userRole === 'admin'"
            class="dropdown"
            :class="{ 'active-element': isActiveGroupsRoute }"
        >
            <router-link to="/groups" class="dropbtn">
                <span class="material-icons" style="padding-right: 1rem"
                    >groups</span
                >
                <span class="text">{{ $t("navigation.groups.title") }}</span>
                <span class="material-icons" style="padding-left: 1rem">
                    {{ isDropdownGroupsOpen ? "expand_less" : "expand_more" }}
                </span>
            </router-link>

            <div class="dropdown-content" v-show="isDropdownGroupsOpen">
                <router-link :to="`/groupChildren/${groupId}`" class="button">
                    <span class="text" style="padding-left: 2rem">{{
                        $t("navigation.groups.children")
                    }}</span>
                </router-link>

                <router-link :to="`/groupStaff/${groupId}`" class="button">
                    <span class="text" style="padding-left: 2rem">{{
                        $t("navigation.groups.staff")
                    }}</span>
                </router-link>

                <router-link :to="`/timetable/${groupId}`" class="button">
                    <span class="text" style="padding-left: 2rem">{{
                        $t("navigation.groups.timetable")
                    }}</span>
                </router-link>

                <router-link :to="`/attendance/${groupId}`" class="button">
                    <span class="text" style="padding-left: 2rem">{{
                        $t("navigation.groups.attendance")
                    }}</span>
                </router-link>
            </div>
        </div>

        <div
            v-if="userRole === 'admin'"
            class="dropdown"
            :class="{
                'active-element': isActiveFamiliesRoute,
                'shift-down': isDropdownGroupsOpen,
            }"
        >
            <router-link to="/families" class="dropbtn">
                <span class="material-icons" style="padding-right: 1rem"
                    >family_restroom</span
                >
                <span class="text">{{ $t("navigation.families.title") }}</span>
                <span class="material-icons" style="padding-left: 1rem">
                    {{ isDropdownFamiliesOpen ? "expand_less" : "expand_more" }}
                </span>
            </router-link>

            <div class="dropdown-content" v-show="isDropdownFamiliesOpen">
                <router-link
                    :to="`/childrenOfFamily/${familyId}`"
                    class="button"
                >
                    <span class="text" style="padding-left: 2rem">{{
                        $t("navigation.families.Children")
                    }}</span>
                </router-link>

                <router-link :to="`/trustedPersons/${familyId}`" class="button">
                    <span class="text" style="padding-left: 2rem">{{
                        $t("navigation.families.trustedPersons")
                    }}</span>
                </router-link>

                <router-link :to="`/payment/${familyId}`" class="button">
                    <span class="text" style="padding-left: 2rem">{{
                        $t("navigation.families.familyPayments")
                    }}</span>
                </router-link>

                <router-link :to="`/createChild/${familyId}`" class="button">
                    <span class="text" style="padding-left: 2rem">{{
                        $t("navigation.families.createChild")
                    }}</span>
                </router-link>
            </div>
        </div>

        <div
            v-if="userRole === 'admin'"
            class="menu"
            :class="{ 'shift-down': isDropdownFamiliesOpen }"
        >
            <router-link to="/staff" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >person</span
                >
                <span class="text">{{ $t("navigation.staff") }}</span>
            </router-link>

            <router-link to="/createUser" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >person_add</span
                >
                <span class="text">{{ $t("navigation.createUser") }}</span>
            </router-link>

            <router-link to="/paymentSettings" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >credit_card</span
                >
                <span class="text">{{ $t("navigation.paymentSettings") }}</span>
            </router-link>

            <router-link to="/Communication" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >mail</span
                >
                <span class="text">{{ $t("navigation.communication") }}</span>
            </router-link>
        </div>

        <div v-if="userRole === 'teacher'" class="menu">
            <router-link
                :to="`/childrenOfGroupProfile/${groupIdForTeacher}`"
                class="button"
            >
                <span class="material-icons" style="padding-left: 1rem"
                    >escalator_warning</span
                >
                <span class="text">{{ $t("navigation.groups.children") }}</span>
            </router-link>

            <router-link
                :to="`/staffOfGroupProfile/${groupIdForTeacher}`"
                class="button"
            >
                <span class="material-icons" style="padding-left: 1rem"
                    >school</span
                >
                <span class="text">{{ $t("navigation.groups.staff") }}</span>
            </router-link>

            <router-link :to="`/timetable/${groupIdForTeacher}`" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >schedule</span
                >
                <span class="text">{{
                    $t("navigation.groups.timetable")
                }}</span>
            </router-link>

            <router-link
                :to="`/attendance/${groupIdForTeacher}`"
                class="button"
            >
                <span class="material-icons" style="padding-left: 1rem"
                    >today</span
                >
                <span class="text">{{
                    $t("navigation.groups.attendance")
                }}</span>
            </router-link>

            <router-link to="/communication" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >mail</span
                >
                <span class="text">{{ $t("navigation.communication") }}</span>
            </router-link>
        </div>

        <div v-if="userRole === 'parent'" class="menu">
            <router-link :to="`/payment/${userRoleId}`" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >credit_card</span
                >
                <span class="text">{{ $t("navigation.payment") }}</span>
            </router-link>

            <router-link :to="`/appDownload`" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >phone_iphone</span
                >
                <span class="text">{{ $t("navigation.mobileApp") }}</span>
            </router-link>

            <router-link :to="`/feedbackSend/${userRoleId}`" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >comment</span
                >
                <span class="text">{{ $t("navigation.feedback") }}</span>
            </router-link>
        </div>

        <div class="flex"></div>

        <div class="menu">
            <router-link to="/settings" class="button">
                <span class="material-icons" style="padding-left: 1rem"
                    >settings</span
                >
                <span class="text">{{ $t("navigation.settings") }}</span>
            </router-link>
            <div @click="logout()" class="button">
                <span class="material-icons" style="padding-left: 1.25rem"
                    >logout</span
                >
                <span class="text">{{ $t("navigation.logout") }}</span>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { ref, watchEffect } from "vue";
import { useRoute } from "vue-router";
import logoURL from "@/assets/img/logo.png";
import { logout } from "@/api/request";

const is_expanded = ref(localStorage.getItem("is_expanded") === "true");
const route = useRoute();
const isDropdownGroupsOpen = ref(false);
const isActiveGroupsRoute = ref(false);

const isDropdownFamiliesOpen = ref(false);
const isActiveFamiliesRoute = ref(false);

const groupId = route.params.groupId;
const familyId = route.params.familyId;
const userRole = localStorage.getItem("userRole");
const groupIdForTeacher = localStorage.getItem("groupId");
const userRoleId = localStorage.getItem("userRoleId");

const ToggleMenu = () => {
    is_expanded.value = !is_expanded.value;
    localStorage.setItem("is_expanded", is_expanded.value);
};

watchEffect(() => {
    const dropdownRoutes = [
        `/groupChildren/${groupId}`,
        `/groupStaff/${groupId}`,
        `/timetable/${groupId}`,
        `/attendance/${groupId}`,
    ];

    const dropdowndFamiliesRoutes = [
        `/childrenOfFamily/${familyId}`,
        `/createChild/${familyId}`,
        `/trustedPersons/${familyId}`,
        `/payment/${familyId}`,
    ];

    if (is_expanded.value) {
        if (dropdownRoutes.includes(route.path)) {
            isDropdownGroupsOpen.value = true;
            isActiveGroupsRoute.value = true;
        } else {
            isDropdownGroupsOpen.value = false;
            isActiveGroupsRoute.value = false;
        }

        if (dropdowndFamiliesRoutes.includes(route.path)) {
            isDropdownFamiliesOpen.value = true;
            isActiveFamiliesRoute.value = true;
        } else {
            isDropdownFamiliesOpen.value = false;
            isActiveFamiliesRoute.value = false;
        }
    } else {
        isDropdownFamiliesOpen.value = false;
        isDropdownGroupsOpen.value = false;
    }
});
</script>

<style lang="scss" scoped>
aside {
    display: flex;
    flex-direction: column;

    background-color: var(--green-light);
    color: var(--green-dark);

    width: calc(2rem + 32px);
    overflow: hidden;
    min-height: 100vh;
    padding-right: 1rem;
    padding-bottom: 1rem;
    padding-top: 1rem;
    transition: 0.2s ease-in-out;
    height: 100%;

    .flex {
        flex: 1 1 0%;
    }

    .logo {
        margin-bottom: 1rem;
        position: relative;
    }

    .logo img {
        width: 4rem;
    }

    .logo-text {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 3rem;
        top: 2rem;
        transition: opacity 0.5s ease-in-out;
        font-size: 37px;
        font-weight: bold;
        color: var(--green-dark);
    }

    .menu-toggle-wrap {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1rem;

        position: relative;
        top: 0;
        transition: 0.2s ease-in-out;

        .menu-toggle {
            transition: 0.2s ease-in-out;
            outline: none;
            .material-icons {
                font-size: 2rem;
                color: var(--green-dark);
                transition: 0.2s ease-out;
            }

            &:hover {
                .material-icons {
                    color: var(--light);
                    transform: translateX(0.5rem);
                }
            }
        }
    }

    .dropdown {
        &.shift-down {
            margin-top: 10.5rem;
        }

        margin: 0 -1rem;
        &.active-element {
            border-right: 5px solid var(--light);
            .dropbtn {
                .material-icons,
                .text {
                    color: var(--light);
                }
            }
        }

        .dropbtn {
            color: var(--green-dark);
            padding: 0.5rem 2rem;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: 0.2s ease-in-out;
            outline: none;

            &.router-link-exact-active {
                border-right: 5px solid var(--light);

                .material-icons,
                .text {
                    color: var(--light);
                }
            }

            .material-icons {
                font-size: 2rem;
                color: var(--green-dark);
                transition: 0.2s ease-in-out;
            }
            .text {
                color: var(--green-dark);
                transition: 0.2s ease-in-out;
            }

            &:hover {
                .material-icons,
                .text {
                    color: var(--light);
                }
            }
        }

        .dropdown-content {
            position: absolute;
            width: 100%;
            z-index: 1;

            .button {
                color: var(--green-dark);
                padding: 0.5rem 1rem;
                text-decoration: none;
                display: block;
                transition: 0.2s ease-in-out;

                &:hover {
                    .text {
                        color: var(--light);
                    }
                }
                &.router-link-exact-active {
                    .material-icons,
                    .text {
                        color: var(--light);
                    }
                }
            }
        }
    }

    h3,
    .button .text {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    h3 {
        color: var(--green-dark);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
    }

    .menu {
        margin: 0 -1rem;

        &.shift-down {
            margin-top: 10.5rem;
        }

        .button {
            display: flex;
            align-items: center;
            text-decoration: none;

            transition: 0.2s ease-in-out;
            padding: 0.5rem 1rem;

            .material-icons {
                font-size: 2rem;
                color: var(--green-dark);
                transition: 0.2s ease-in-out;
            }
            .text {
                color: var(--green-dark);
                transition: 0.2s ease-in-out;
            }

            &:hover {
                .material-icons,
                .text {
                    color: var(--light);
                }
            }

            &.router-link-exact-active {
                border-right: 5px solid var(--light);

                .material-icons,
                .text {
                    color: var(--light);
                }
            }
        }
    }

    .footer {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;

        p {
            font-size: 0.875rem;
            color: var(--green-dark);
        }
    }

    &.isDropdownGroupsOpen {
        .menu {
            margin-top: 10rem;
        }
    }

    &.isDropdownFamiliesOpen {
        .menu {
            margin-top: 10rem;
        }
    }

    &.is-expanded {
        width: var(--sidebar-width);

        .menu-toggle-wrap {
            top: -3rem;

            .menu-toggle {
                transform: rotate(-180deg);
            }
        }

        h3,
        .button .text {
            opacity: 1;
        }

        .button {
            .material-icons {
                margin-right: 1rem;
            }
        }

        .footer {
            opacity: 0;
        }
    }

    @media (max-width: 1024px) {
        position: absolute;
        z-index: 99;
        height: 100%;
    }
}
</style>
