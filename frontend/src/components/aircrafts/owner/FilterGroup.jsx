import SearchFilterDefault from "../../elemets/searchFilter/SearchFilterDefault";
import Grid from "@mui/material/Grid";
import React from "react";

function FilterGroup ({ filterData, setFilterData }) {

  return <>
    <Grid item xs={3}>
      <SearchFilterDefault
        inputLabel="Serial number"
        filterData={filterData}
        setFilterData={setFilterData}
        fieldName="serialNumber"
      />
    </Grid>
    <Grid item xs={3}>
      <SearchFilterDefault
        inputLabel="Model"
        filterData={filterData}
        setFilterData={setFilterData}
        fieldName="model.plane"
      />
    </Grid>
    <Grid item xs={3}>
      <SearchFilterDefault
        inputLabel="Company"
        filterData={filterData}
        setFilterData={setFilterData}
        fieldName="company.name"
      />
    </Grid>
  </>;
}

export default FilterGroup;