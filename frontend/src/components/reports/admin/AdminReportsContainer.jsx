import React, { useContext, useEffect, useState } from "react";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';
import { Line } from 'react-chartjs-2';
import {responseStatus} from "../../../utils/consts";
import {InputLabel, MenuItem, Select} from "@mui/material";

const AdminReportsContainer = () => {
  const [myData,setMyData]=useState([]);

  const [currentStat,setCurrentStat]=useState(1);

  const loadData = (num) => {

    axios.get("/api/get-website-stat?num="+num, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data) {
        setMyData(response.data);
      }
    }).catch(error => {
      console.log("error");
    });
  };

  useEffect(() => {
    loadData(currentStat);
  }, []);

  useEffect(() => {
    loadData(currentStat);
  }, [currentStat]);

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
        position: 'top',
      },
    },
  };

  let labels=[];
  if(currentStat===1){
    labels = myData.map((data) => data.date);
  }
  else if(currentStat===2){
    labels = myData.map((data) => data.company);
  }
  const chartData = {
    labels,
    datasets: [
      {
        label: 'Daily profit fluctuation',
        data: myData.map((data) => data.income),
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
      },
    ],
  };

  return (
      <>
        <h1>Admin reports</h1>
        <InputLabel id="company-select-label">Company List</InputLabel>
        <Select
            labelId="company-select-label"
            id="company-select"
            label="Company List"
        >
          <MenuItem value={"Income by companies"} onClick={()=>{setCurrentStat(2)}}>Income by companies</MenuItem>
          <MenuItem value={"Income by dates"} onClick={()=>{setCurrentStat(1)}}>Income by dates</MenuItem>
        </Select>
        <Line options={options} data={chartData} />;
      </>
  );
};

export default AdminReportsContainer;