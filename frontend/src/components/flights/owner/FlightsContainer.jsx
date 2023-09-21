import React, { useEffect, useState } from "react";
import {Helmet} from "react-helmet-async";
import { Breadcrumbs, Button, Link, Pagination, Typography } from "@mui/material";
import { NavLink, useNavigate, useSearchParams } from "react-router-dom";
import FlightsCreate from "./FlightsCreate";
import { checkFilterItem, fetchFilterData } from "../../../utils/fetchFilterData";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import Notification from "../../elemets/notification/Notification";
import Grid from "@mui/material/Grid";
import FlightsTable from "../manager/FlightsTable";

const FlightsContainer = () => {

  const navigate = useNavigate();
  const [requestData, setRequestData] = useState();
  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const [flights, setFlights] = useState(null);
  const [searchParams] = useSearchParams();

  const [paginationInfo, setPaginationInfo] = useState({
    totalItems: null,
    totalPageCount: null,
    itemsPerPage: 10
  });

  const [filterData, setFilterData] = useState({
    "page": checkFilterItem(searchParams, "page", 1, true)
  });

  const loadFlights = () => {
    let filterUrl = fetchFilterData(filterData);
    navigate(filterUrl);

    axios.get("/api/company-flights" + filterUrl + "&itemsPerPage=" + paginationInfo.itemsPerPage, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
        setFlights(response.data["hydra:member"]);
        setPaginationInfo({
          ...paginationInfo,
          totalItems: response.data["hydra:totalItems"],
          totalPageCount: Math.ceil(response.data["hydra:totalItems"] / paginationInfo.itemsPerPage)
        });
      }
    }).catch(error => {
      console.log("error");
    });
  };

  useEffect(() => {
    loadFlights();
  }, [requestData, filterData]);

  const onChangePage = (event, page) => {
    setFilterData({ ...filterData, page: page });
  };

  return (
    <>
      {notification.visible &&
        <Notification
          notification={notification}
          setNotification={setNotification}
        />
      }
      <Helmet>
        <title>
          Flights
        </title>
      </Helmet>

      <Grid container spacing={1}>
        <Grid item xs={12}>
          <Button
            to="/cabinet/flights/new"
            component={NavLink}
            variant="outlined"
          >
            Create flight
          </Button>
        </Grid>

        <p></p>

        <Grid item xs={12}>

        </Grid>
      </Grid>
    </>
  );
};

export default FlightsContainer;