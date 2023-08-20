import axios from "axios";

const apiAxios = axios.create({
  baseURL: process.env.REACT_APP_API_URL || "http://localhost/api",
});

export const fetchAirports = async () => {
  const {
    data: { data },
  } = await apiAxios.get("/airports");
  return data;
};

export const fetchAirlines = async () => {
  const {
    data: { data },
  } = await apiAxios.get("/airlines");
  return data;
};

export const fetchTrips = async (searchQuery) => {
  const {
    data: { data, pagination },
  } = await apiAxios.get("/trips", { params: searchQuery });

  return { data, pagination };
};
