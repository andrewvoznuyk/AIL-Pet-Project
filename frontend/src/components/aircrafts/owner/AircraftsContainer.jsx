import { NavLink, useNavigate, useSearchParams } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { Button, Pagination } from "@mui/material";
import Grid from "@mui/material/Grid";
import React, { useEffect, useState } from "react";
import { checkFilterItem, fetchFilterData } from "../../../utils/fetchFilterData";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import Notification from "../../elemets/notification/Notification";
import DataTable from "./DataTable";
import FilterGroup from "./FilterGroup";

const AircraftsContainer = () => {

  const navigate = useNavigate();
  const [requestData, setRequestData] = useState();
  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const [aircrafts, setAircrafts] = useState(null);
  const [searchParams] = useSearchParams();

  const [paginationInfo, setPaginationInfo] = useState({
    totalItems: null,
    totalPageCount: null,
    itemsPerPage: 10
  });

  const [filterData, setFilterData] = useState({
    "page": checkFilterItem(searchParams, "page", 1, true),
    "serialNumber": checkFilterItem(searchParams, "serialNumber", ""),
    "model.plane": checkFilterItem(searchParams, "model.plane", ""),
    "company.name": checkFilterItem(searchParams, "company.name", "")
  });

  const loadFlights = () => {
    let filterUrl = fetchFilterData(filterData);
    navigate(filterUrl);

    axios.get("/api/aircraft" + filterUrl + "&itemsPerPage=" + paginationInfo.itemsPerPage, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
        setAircrafts(response.data["hydra:member"]);
        console.log(response.data["hydra:member"])
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
            to="/cabinet/aircrafts/new"
            component={NavLink}
            variant="outlined"
          >
            Create flight
          </Button>
        </Grid>

        <p></p>

        <Grid item xs={12}>

        </Grid>

        <FilterGroup filterData={filterData} setFilterData={setFilterData}/>

        <p></p>

        <DataTable fetchedData={aircrafts} reloadData={loadFlights} />
        {paginationInfo.totalPageCount > 1 &&
          <Pagination
            count={paginationInfo.totalPageCount}
            shape="rounded"
            page={filterData.page}
            onChange={(event, page) => onChangePage(event, page)}
          />}
      </Grid>
    </>
  );
};

export default AircraftsContainer;