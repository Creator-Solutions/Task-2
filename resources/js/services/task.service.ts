import axios from "axios";

const endpoints = {
    getTasks: "/tasks/",
    storeTask: "/tasks/store",
};

const headers = {
    "Content-Type": "application/json",
    "Access-Control-Allow-Origin": "*",
};

const baseUrl = "http://localhost:8000/api";

export const getTaskService = async () => {
    const axiosConfig = {
        method: "GET",
        url: baseUrl + endpoints.getTasks,
        headers: headers,
    };

    return await axios
        .request(axiosConfig)
        .then((res) => {
            return {
                isError: false,
                data: res.data,
                error: "",
            };
        })
        .catch((err) => {
            return {
                isError: true,
                data: "",
                error: err,
            };
        });
};

export const createTaskService = async (data) => {
    const { task_title, task_description, task_completed } = data;

    const axiosConfig = {
        method: "POST",
        url: baseUrl + endpoints.storeTask,
        data: {
            task_title: task_title,
            task_description: task_description,
            task_completed: task_completed,
        },
        headers: headers,
    };

    return await axios
        .request(axiosConfig)
        .then((res) => {
            return {
                isError: false,
                data: res.data,
                error: "",
            };
        })
        .catch((err) => {
            return {
                isError: true,
                data: "",
                error: err,
            };
        });
};
