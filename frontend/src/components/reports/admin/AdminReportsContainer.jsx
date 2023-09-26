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

const AdminReportsContainer = () => {
  const [myData,setMyData]=useState(
      [
        {
          id: 1,
          date: 2016,
          income: 80000,
        },
        {
          id: 2,
          date: 2017,
          income: 40500,
        },
        {
          id: 2,
          date: 2018,
          income: 70500,
        },
      ]
  );

  const loadData = () => {

    axios.get("/api/get-company-stat", userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
        setMyData(response.data["hydra:member"]);
      }
    }).catch(error => {
      console.log("error");
    });
  };

  useEffect(() => {
    loadData();
  }, []);
  
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
      title: {
        display: true,
        text: 'Chart.js Line Chart',
      },
    },
  };

    const labels = myData.map((data) => data.date);

    const chartData = {
    labels,
    datasets: [
      {
        label: 'Dataset 1',
        data: myData.map((data) => data.income),
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
      },
    ],
  };

  return (
    <>
      <h1>Admin reports</h1>
      <Line options={options} data={chartData} />;
    </>
  );
};

export default AdminReportsContainer;