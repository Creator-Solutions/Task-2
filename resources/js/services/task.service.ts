import axios from "axios";

const endpoints = {
    getTasks: "/tasks/",
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
