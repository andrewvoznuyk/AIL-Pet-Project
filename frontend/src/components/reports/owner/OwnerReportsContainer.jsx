import React, { useContext, useEffect, useState } from "react";
import axios from "axios";
import { Helmet } from "react-helmet-async";
import Notification from "../../elemets/notification/Notification";
import { responseStatus } from "../../../utils/consts";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { checkFilterItem, fetchFilterData } from "../../../utils/fetchFilterData";
import { NavLink, useNavigate, useSearchParams } from "react-router-dom";
import { Button, Pagination, TableCell, TableRow } from "@mui/material";
import Grid from "@mui/material/Grid";

const OwnerReportsContainer = () => {

  const loadData = () => {

    axios.get("", userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {

      }
    }).catch(error => {
      console.log("error");
    });
  };


  return (
    <>
      <h1>Owner reports</h1>
    </>
  );
};

export default OwnerReportsContainer;