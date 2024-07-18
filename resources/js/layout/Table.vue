<script setup>
import { Util } from "../utils/utils";
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
    onEditTask: {
        type: [Function, null],
        required: true,
    },
    onDeleteTask: {
        type: [Function, null],
        required: true,
    },
});

const onEditTask = (id) => {
    props.onEditTask(id);
};

const onDeleteTask = (id) => {
    props.onDeleteTask(id);
};
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
                class="mt-8"
                :headers="props.headers"
                :items="props.rows"
            >
                <template class="h-14" #item="{ item }">
                    <tr>
                        <td class="text-center h-14">{{ item.id }}</td>
                        <td class="text-center">{{ item.task_title }}</td>
                        <td class="text-center">
                            {{ item.task_description }}
                        </td>
                        <td class="text-center">{{ item.task_completed }}</td>
                        <td class="text-center">
                            {{ Util.formatDate(item.created_at) }}
                        </td>
                        <td class="text-center">
                            {{ Util.formatDate(item.updated_at) }}
                        </td>
                        <td class="w-26 text-center">
                            <div
                                class="w-full h-full flex flex-row justify-evenly"
                            >
                                <v-btn
                                    color="buttonSecondary"
                                    class="self-center"
                                    @click="onEditTask(item.id)"
                                    >Edit</v-btn
                                >
                                <v-btn
                                    color="buttonSecondary"
                                    class="self-center ml-5"
                                    @click="onDeleteTask(item.id)"
                                    >Delete</v-btn
                                >
                            </div>
                        </td>
                    </tr>
                </template></v-data-table
            >
        </div>
    </v-container>
</template>
