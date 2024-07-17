<script>
import { getTaskService } from "../services/task.service";
import Header from "./Header.vue";
import Table from "./Table.vue";

export default {
    components: {
        Header,
        Table,
    },
    data() {
        return {
            data: [],
            headers: [
                { key: "id", title: "Id" },
                { key: "task_title", title: "Task Title" },
                { key: "task_description", title: "Task Description" },
                { key: "task_completed", title: "Task Completed" },
                { key: "created_at", title: "Created At" },
                { key: "updated_at", title: "Updated At" },
            ],
            loading: false,
            error: null,
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
            this.loading = true;
            this.error = null;
            try {
                let response = await getTaskService();

                if (!response.isError && response.data.tasks) {
                    this.data = response.data.tasks;
                } else {
                    this.data = [];
                }
            } catch (error) {
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },

        onAddProps() {
            console.log("Clicked");
        },
    },
};
</script>

<template>
    <v-app>
        <v-main>
            <Header />
            <Table :rows="data" :headers="headers" :onAddTasks="onAddProps" />
        </v-main>
    </v-app>
</template>
