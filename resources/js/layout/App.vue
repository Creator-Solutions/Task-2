<script setup>
import {
    getTaskService,
    createTaskService,
    deleteTaskService,
} from "../services/task.service";
import { ref } from "vue";
import Header from "./Header.vue";
import Table from "./Table.vue";
import NewTaskForm from "./NewTaskForm.vue";

const showPopUp = ref(false);
const showEditPopUp = ref(false);
const title = ref("");
const taskTitle = ref("");
const taskDescription = ref("");
const submitAction = ref("");
const snackBarMessage = ref("");
const showSnackBar = ref(false);
const taskCompleted = ref(false);
const data = ref([]);
const loading = ref(false);
const error = ref(null);

const headers = ref([
    { key: "id", title: "Id" },
    { key: "task_title", title: "Task Title" },
    { key: "task_description", title: "Task Description" },
    { key: "task_completed", title: "Task Completed" },
    { key: "created_at", title: "Created At" },
    { key: "updated_at", title: "Updated At" },
    { key: "", title: "Actions" },
]);

const onAddTask = async () => {
    showPopUp.value = true;
    title.value = "New Task";
    submitAction.value = "Create Task";

    try {
        let data = {
            task_title: taskTitle.value,
            task_description: taskDescription.value,
            task_completed: taskCompleted.value,
        };
        console.log(data);

        const response = await createTaskService(data);

        if (!response.isError && response.data) {
            console.log(response.data);
            if (response.data.status) {
                showPopUp.value = false;
                window.location.reload();
            }
        } else {
            error.value = response.error;
        }
    } catch (err) {
        error.value = err.message;
    }
};

const onEditTask = (id) => {
    showEditPopUp.value = true;
    title.value = "Edit Task";
    submitAction.value = "Edit Task";
    console.log(id);
};

const onDeleteTask = async (id) => {
    try {
        const response = await deleteTaskService(id);

        if (!response.isError && response.data) {
            snackBarMessage.value = "Task Deleted Successfully";
            showSnackBar.value = true;
        } else {
            error.value = response.error;
            console.log(response.error);
        }
    } catch (err) {
        console.log(err);
        error.value = err;
    }
};

const onCloseSnackBar = () => {
    showSnackBar.value = false;
    window.location.reload();
};

const onCheckTaskCompleted = () => {
    taskCompleted.value = !taskCompleted.value;
};

const fetchData = async () => {
    loading.value = true;
    error.value = null;
    try {
        let response = await getTaskService();
        if (!response.isError && response.data.tasks) {
            data.value = response.data.tasks;
        } else {
            data.value = [];
        }
    } catch (error) {
        error.value = error.message;
    } finally {
        loading.value = false;
    }
};

fetchData(); // Call fetchData on component setup
</script>

<template>
    <v-app>
        <v-main>
            <Header />
            <Table
                :rows="data"
                :headers="headers"
                :onAddTasks="onAddTask"
                :onEditTask="onEditTask"
                :onDeleteTask="onDeleteTask"
            />

            <v-dialog v-model="showPopUp" max-width="500">
                <NewTaskForm
                    :showPopUpProp="showPopUp"
                    :title="title"
                    v-model:taskTitle="taskTitle"
                    v-model:taskDescription="taskDescription"
                    v-model:taskCompleted="taskCompleted"
                    :taskCompleted="taskCompleted"
                    :onCheckTaskCompleted="onCheckTaskCompleted"
                    :onSubmitTask="onAddTask"
                    :submitAction="submitAction"
                />
            </v-dialog>

            <v-snackbar v-model="showSnackBar">
                {{ snackBarMessage }}

                <template v-slot:actions>
                    <v-btn color="pink" variant="text" @click="onCloseSnackBar">
                        Close
                    </v-btn>
                </template>
            </v-snackbar>

            <v-dialog v-model="showEditPopUp" max-width="500">
                <NewTaskForm
                    :showPopUpProp="showEditPopUp"
                    :title="title"
                    v-model:taskTitle="taskTitle"
                    v-model:taskDescription="taskDescription"
                    v-model:taskCompleted="taskCompleted"
                    :onCheckTaskCompleted="onCheckTaskCompleted"
                    :onSubmitTask="onEditTask"
                    :submitAction="submitAction"
                />
            </v-dialog>
        </v-main>
    </v-app>
</template>
