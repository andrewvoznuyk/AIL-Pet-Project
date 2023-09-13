import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { default as OwnerFlightsContainer } from "../../components/flights/owner/FlightsContainer";
import { AppContext } from "../../App";
import { flights } from "../../rbac-consts";

const FlightsPage = () => {
  const { user } = useContext(AppContext);

  return (
    <>
        <OwnerFlightsContainer />
      {/*<Can*/}
      {/*  role={user.roles}*/}
      {/*  perform={flights.OWNER}*/}
      {/*  yes={() => <OwnerFlightsContainer />}*/}
      {/*/>*/}
      {/*<Can*/}
      {/*  role={user.roles}*/}
      {/*  perform={flights.MANAGER}*/}
      {/*  yes={() => <ClientGoodsContainer />}*/}
      {/*/>*/}
      {/*  <Can*/}
      {/*      role={user.roles}*/}
      {/*      perform={flights.USER}*/}
      {/*      yes={() => <ClientGoodsContainer />}*/}
      {/*  />*/}
    </>
  );
};

export default FlightsPage;