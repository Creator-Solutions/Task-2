<script setup>
const props = defineProps({
    rows: {
        type: [Array, []],
        required: true,
    },
    headers: {
        type: [Array, []],
        required: true,
    },
    onAddTasks: {
        type: [Function, null],
        required: true,
    },
});
</script>

<template>
    <v-container>
        <div class="w-full h-full mt-5">
            <div class="w-full h-12 flex flex-row justify-between bg-[#]">
                <p class="self-center">Tasks</p>
                <v-btn
                    class="w-48"
                    color="buttonPrimary"
                    @click="props.onAddTasks"
                    >Add Task</v-btn
                >
            </div>
            <v-data-table
                class="center-table"
                :headers="props.headers"
                :items="props.rows"
            >
                <template class="h-14" #item="{ item }">
                    <td class="text-center h-14">{{ item.id }}</td>
                    <td class="text-center">{{ item.task_title }}</td>
                    <td class="text-center">
                        {{ item.task_description }}
                    </td>
                    <td class="text-center">{{ item.task_completed }}</td>
                    <td class="text-center">{{ item.created_at }}</td>
                    <td class="text-center">{{ item.updated_at }}</td>
                </template></v-data-table
            >
        </div>
    </v-container>
</template>

<style scoped>
.center-table .v-data-table-header th {
    text-align: center;
}
.center-table td {
    text-align: center;
    vertical-align: middle;
}
</style>
