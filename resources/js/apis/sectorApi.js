import axios from "axios";

const sectorApi = axios.create({
    baseURL: "/api/web/sector",
});

export default sectorApi;