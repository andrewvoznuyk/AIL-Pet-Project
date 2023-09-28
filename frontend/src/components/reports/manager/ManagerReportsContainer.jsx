import React, { useEffect, useState } from "react";
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
  Legend
} from "chart.js";
import { Line } from "react-chartjs-2";
import { responseStatus } from "../../../utils/consts";

const ManagerReportsContainer = () => {
  const [myData, setMyData] = useState(
    []
  );

  const loadData = () => {

    axios.get("/api/get-company-stat", userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data) {
        setMyData(response.data);
        console.log(response.data);
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
      <h1>Manager reports</h1>
      <Line options={options} data={chartData} />
    </>
  );
};

export default ManagerReportsContainer;