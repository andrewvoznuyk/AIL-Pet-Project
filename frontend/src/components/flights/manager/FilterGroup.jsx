import SearchFilterDefault from "../../elemets/searchFilter/SearchFilterDefault";
import SearchFilterSelective from "../../elemets/searchFilter/SearchFilterSelective";
import Grid from "@mui/material/Grid";
import React from "react";

function FilterGroup ({ filterData, setFilterData }) {

  return <>
    <Grid item xs={3}>
      <SearchFilterDefault
        inputLabel="Aircraft"
        filterData={filterData}
        setFilterData={setFilterData}
        fieldName="aircraft.serialNumber"
      />
    </Grid>
    <Grid item xs={3}>
      <SearchFilterDefault
        inputLabel="From"
        filterData={filterData}
        setFilterData={setFilterData}
        fieldName="fromLocation.airport.name"
      />
    </Grid>
    <Grid item xs={3}>
      <SearchFilterDefault
        inputLabel="To"
        filterData={filterData}
        setFilterData={setFilterData}
        fieldName="toLocation.airport.name"
      />
    </Grid>
    <Grid item xs={3}>
      <SearchFilterDefault
        inputLabel="Departure"
        filterData={filterData}
        setFilterData={setFilterData}
        fieldName="departure[gte]"
        inputType="datetime-local"
      />
    </Grid>
  </>;
}

export default FilterGroup;