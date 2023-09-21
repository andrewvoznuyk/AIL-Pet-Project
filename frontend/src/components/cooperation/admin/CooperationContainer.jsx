import {
  Breadcrumbs,
  Grid,
  Link,
  Typography,
  Pagination
} from "@mui/material";
import React, { useEffect, useState } from "react";
import { Helmet } from "react-helmet-async";
import { NavLink, useNavigate, useSearchParams } from "react-router-dom";
import Notification from "../../elemets/notification/Notification";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import { checkFilterItem, fetchFilterData } from "../../../utils/fetchFilterData";
import FormsFilter from "./FormsFilter";
import FormsList from "./FormsList";

const CooperationContainer = () => {

  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const navigate = useNavigate();
  const [searchParams] = useSearchParams();

  const [forms, setForms] = useState(null);

  const [paginationInfo, setPaginationInfo] = useState({
    totalItems: null,
    totalPageCount: null,
    itemsPerPage: 10
  });

  const [filterData, setFilterData] = useState({
    "page": checkFilterItem(searchParams, "page", 1, true),
    "companyName": checkFilterItem(searchParams, "companyName", null),
    "fullname": checkFilterItem(searchParams, "fullname", null),
    "email": checkFilterItem(searchParams, "email", null),
    "about": checkFilterItem(searchParams, "about", null),
    "airport": checkFilterItem(searchParams, "airport", null),
    "documents": checkFilterItem(searchParams, "documents", null),
    "dateOfApplication": checkFilterItem(searchParams, "dateOfApplication", null),
    "status": checkFilterItem(searchParams, "status", null)
  });

  const fetchForms = () => {
    let filterUrl = fetchFilterData(filterData);

    navigate(filterUrl);

    axios.get("https://courselab.com/api/cooperation-forms" + filterUrl + "&itemsPerPage=" + paginationInfo.itemsPerPage,
      userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
        setForms(response.data["hydra:member"]);
        setPaginationInfo({
          ...paginationInfo,
          totalItems: response.data["hydra:totalItems"],
          totalPage: Math.ceil(response.data["hydra:totalItems"] / paginationInfo.itemsPerPage)
        });
      }
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    });
  };

  const onChangePage = (event, page) => {
    setFilterData({ ...filterData, page: page });
  };

  useEffect(() => {
    fetchForms();
    console.log(forms);
  }, [filterData]);

  return (
    <>
      <Helmet>
        <title>
          Cooperation
        </title>
      </Helmet>

      <Breadcrumbs aria-label="breadcrumb">
        <Link component={NavLink} underline="hover" color="inherit" to="/">
          Home
        </Link>
        <Link component={NavLink} underline="hover" color="inherit" to="/panel/goods">
          Goods
        </Link>
        <Typography color="text.primary">Cooperation</Typography>
      </Breadcrumbs>
      <Typography variant="h4" component="h1" mt={1}>
        Cooperation
      </Typography>
      <Grid container>
        {notification.visible &&
          <Notification notification={notification} setNotification={setNotification} />
        }
        <div>
          <FormsFilter filterData={filterData} setFilterData={setFilterData} />
        </div>
        <FormsList forms={forms} />
        {paginationInfo.totalPageCount > 1 &&
          <Pagination
            count={paginationInfo.totalPageCount}
            shape="rounded"
            page={filterData.page}
            onChange={(event, page) => onChangePage(event, page)}
          />
        }
      </Grid>
    </>
  );
};

export default CooperationContainer;