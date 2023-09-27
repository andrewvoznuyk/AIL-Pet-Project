import React, { useEffect, useState } from "react";
import axios from "axios";
import { responseStatus } from "../../../utils/consts";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { InputLabel, MenuItem, Select } from "@mui/material";
import {
  CategoryScale,
  Chart as ChartJS, Legend,
  LinearScale,
  LineElement,
  PointElement,
  Title,
  Tooltip
} from "chart.js";
import { Line } from "react-chartjs-2";

const OwnerReportsContainer = () => {

  const [myData, setMyData] = useState(
    []
  );
  const [companyList, setCompanyList] = useState(null);
  const [currentCompany, setCurrentCompany] = useState({
    id: ""
  });
  const loadData = () => {

    axios.get("/api/get-company-stat?id=" + currentCompany.id, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data) {
        setMyData(response.data);
      }
    }).catch(error => {
      console.log("error");
    });
  };
  const requestCompany = () => {
    axios.get("/api/user-company", userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data) {
        setCompanyList(response.data);
      }
    }).catch(error => {
      console.log("error");
    });
  };

  useEffect(() => {
    requestCompany();
  }, []);

  useEffect(() => {
    loadData();
  }, [currentCompany]);

  ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
  );

  const options = {
    responsive: true,
    plugins: {
      legend: {
        position: "top"
      },
      title: {
        display: true,
        text: "Company reporting"
      }
    }
  };

  const labels = myData.map((data) => data.date);

  const chartData = {
    labels,
    datasets: [
      {
        label: "Daily profit fluctuation",
        data: myData.map((data) => data.income),
        borderColor: "rgb(255, 99, 132)",
        backgroundColor: "rgba(255, 99, 132, 0.5)"
      }
    ]
  };

  return (
    <>
      <h1>Owner reports</h1>
      <InputLabel id="company-select-label">Company List</InputLabel>
      <Select
        labelId="company-select-label"
        id="company-select"
        label="Company List"
      >
        {companyList && companyList.map((item, key) => (
          <MenuItem key={key} value={item.name} onClick={() => {setCurrentCompany(item);}}>{item.name}</MenuItem>
        ))}
      </Select>
      <Line options={options} data={chartData} />;
    </>
  );
};

export default OwnerReportsContainer;