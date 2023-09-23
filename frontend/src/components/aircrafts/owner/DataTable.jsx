import React, { useState } from "react";
import TableGenerator from "../../elemets/table/TableGenerator";
import PopupDefault from "../../elemets/popup/PopupDefault";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import { useNavigate } from "react-router-dom";
import AircraftRowItem from "./AircraftRowItem";

const DataTable = ({ fetchedData, reloadData }) => {
  const navigate = useNavigate();

  const [selectedAircraft, setSelectedAircraft] = useState(0);
  const [isPopupFinishOpen, setPopupFinishOpen] = useState(false);

  const openModalDeleteAircraft = (aircraft) => {
    setSelectedAircraft(aircraft);
    setPopupFinishOpen(true);
  };

  const closeModals = (e) => {
    setPopupFinishOpen(false);
  };

  const deleteAircraft = () => {
    //
    axios.put(`/api/company-flights/delete/${selectedAircraft}`, {}, userAuthenticationConfig(false)).then(response => {
      console.log(response);
      if (response.status === responseStatus.HTTP_OK) {
      }
    }).catch(error => {

    }).finally(() => {
      reloadData();
      closeModals();
    });
  };

  return (
    <>
      <TableGenerator
        titles={["Serial Number", "Model", "Company", ""]}
        items={
          fetchedData && fetchedData.map((item, key) => (
            <AircraftRowItem
              key={key}
              aircraft={item}
              openModalDeleteFlight={openModalDeleteAircraft}
              navigate={navigate}
            />
          ))
        }
      />

      <PopupDefault
        isOpen={isPopupFinishOpen}
        title={"Delete Flight #" + selectedAircraft}
        description={"Are you sure you want to delete this aircraft?"}
        acceptLabel="Yes"
        declineLabel="No"
        onAccept={() => deleteAircraft()}
        onDecline={() => closeModals()}
        handleClose={() => closeModals()}
      />
    </>
  );
};

export default DataTable;