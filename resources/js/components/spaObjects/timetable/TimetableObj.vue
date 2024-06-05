<template>
    <div class="alert alert-danger py-2" role="alert" v-if="errored">
        {{ error }}
    </div>
    <div class="alert alert-danger mt-3 py-2" role="alert" v-if="messaged">
        {{ message }}
    </div>
    <div class="timetable-container">
        <InfoLoader :loading="loadingOfLessons" />
        <div v-for="(day, index) in days" :key="index" class="column">
            <div class="day-header">{{ $t("timetable.days." + index) }}</div>
            <InfoBoxLoader class="pt-1" :loading="loading" />
            <div v-if="!loading">
                <div
                    v-if="!lessons[day.id] || lessons[day.id].length === 0"
                    class="no-lessons"
                >
                    <h5>
                        {{ $t("timetable.lessons.noLessons") }}
                    </h5>
                </div>
                <div v-else>
                    <div
                        v-for="(lesson, lessonIndex) in lessons[day.id]"
                        :key="lessonIndex"
                    >
                        <div class="lesson">
                            <h5>{{ lesson.action_name }}</h5>
                            <p>
                                {{ formatTime(lesson.start_time) }} -
                                {{ formatTime(lesson.end_time) }}
                            </p>
                            <span
                                class="close-btn material-icons"
                                @click="
                                    showCustomConfirmation(lesson.id_lesson)
                                "
                                >close</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ConfirmationMenu
        :showModal="showModal"
        :message="$t('timetable.lessons.deleteMessage')"
        :buttonConfirm="$t('spa.buttons.delete')"
        :buttonCancel="$t('spa.buttons.cancel')"
        @confirm="deleteLessonConfirm"
        @cancel="cancelDelete"
    />
</template>

<script>
import { getCookies } from "@/api/request";

import axios from "axios";
import router from "@/router/router.js";

import ConfirmationMenu from "@/components/Elements/ConfirmationMenu.vue";
import InfoBoxLoader from "@/components/Elements/InfoBoxLoader.vue";
import InfoLoader from "@/components/Elements/InfoLoader.vue";

export default {
    components: {
        ConfirmationMenu,
        InfoBoxLoader,
        InfoLoader,
    },
    data() {
        return {
            lessons: [],
            days: [],
            groupId: this.$route.params.groupId,
            lessonToDelete: "",
            showModal: false,
            loading: true,
            loadingOfLessons: true,
            errored: false,
            error: "",
        };
    },
    mounted() {
        this.fetchDays();
    },
    methods: {
        async fetchDays() {
            try {
                const response = await axios.get("api/days", {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.days = response.data.data;
                this.fetchLessons();
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.days");
                console.error(this.$t("loading.days"), error);
            }
        },
        async fetchLessons() {
            try {
                this.loadingOfLessons = false;
                const response = await axios.get(
                    `api/index_by_group_for_week/${this.groupId}`,
                    {
                        headers: {
                            "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                        },
                    }
                );
                this.lessons = response.data;
                console.log(response.data);
            } catch (error) {
                this.errored = true;
                this.error = this.$t("loading.activities");
                console.error(this.$t("loading.activities"), error);
            } finally {
                this.loading = false;
            }
        },
        async deleteLesson(lessonId) {
            try {
                await axios.delete(`api/lessons/${lessonId}`, {
                    headers: {
                        "X-XSRF-Token": getCookies("XSRF-TOKEN"),
                    },
                });
                this.closeModal();
                router.go();
            } catch (error) {
                console.error("Lesson delete error", error);
                if (error.response.data.error) {
                    this.errored = true;
                    this.error = error.response.data.error;
                }
                if (error.response.data.message) {
                    this.messaged = true;
                    this.message = error.response.data.message;
                }
            }
        },
        showCustomConfirmation(lessonId) {
            this.lessonToDelete = lessonId;
            this.showModal = true;
        },
        deleteLessonConfirm() {
            this.deleteLesson(this.lessonToDelete);
            this.closeModal();
        },
        cancelDelete() {
            this.lessonToDelete = null;
            this.showModal = false;
        },
        closeModal() {
            this.showModal = false;
        },
        formatTime(time) {
            return time ? time.slice(0, -3) : "";
        },
    },
};
</script>

<style>
.timetable-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    background-color: var(--yellow-light-group);
    border-radius: 10px;
    background-clip: padding-box;
    border: 1px solid var(--orange-border);
}

.day-column {
    background-color: var(--yellow-light-group);
}

.day-header {
    text-align: center;
    color: var(--light);
    font-weight: bold;
    border-radius: 5px;
    margin: 0.5rem;
    padding: 5px;
    background-color: var(--green-light);
}

.lesson {
    position: relative;
    text-align: center;
    background-color: var(--yellow-light-back);
    border-radius: 10px;
    background-clip: padding-box;
    border: 1px solid var(--orange);
    padding: 10px;
    margin: 0.5rem;
    margin-top: 0.5rem;
}

.no-lessons {
    position: relative;
    text-align: center;
    background-color: var(--orange);
    border-radius: 10px;
    background-clip: padding-box;
    padding: 10px;
    margin: 0.5rem;
}

.close-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: var(--red-main);
    color: var(--light);
    font-size: 17px;
    font: bold;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

@media (min-width: 992px) {
    .timetable-container {
        min-height: 90vh;
    }
}
</style>

<!-- <style>
.timetable-container {
  display: flex;
  background-color: var(--yellow-light-group);
  border-radius: 10px;
  background-clip: padding-box;
  border: 1px solid var(--orange-border);
}

.column {
  flex: 1;
}

.day-header {
  text-align: center;
  color: var(--light);
  font-weight: bold;
  border-radius: 5px;
  margin: 1rem;
  padding: 10px;
  background-color: var(--green-light);
}

.lesson {
  position: relative;
  text-align: center;
  background-color: var(--yellow-light-back);
  border-radius: 10px;
  background-clip: padding-box;
  border: 1px solid var(--orange);
  padding: 10px;
  margin: 1rem;
}

.close-btn {
  position: absolute;
  top: 5px;
  right: 5px;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background-color: var(--red-main);
  color: var(--light);
  font-size: 17px;
  font: bold;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

@media (max-width: 576px) {
  /* Очень маленькие экраны: каждый день недели отображается в один столбец */
  .timetable-container {
    flex-direction: column;
  }
}

@media (min-width: 577px) and (max-width: 991px) {
  /* Экраны среднего размера: 4 дня недели сверху, 3 снизу */
  .timetable-container {
    flex-wrap: wrap;
    justify-content: space-between;
  }

  .column {
    width: calc(50% - 1rem); /* Ширина столбца для средних экранов */
    margin-bottom: 1rem;
  }
}

@media (min-width: 992px) {
  /* Крупные экраны: все 7 дней недели в одном ряду */
  .timetable-container {
    min-height: 90vh;
  }

  .column {
    flex: 1;
  }
}
</style>
 -->
