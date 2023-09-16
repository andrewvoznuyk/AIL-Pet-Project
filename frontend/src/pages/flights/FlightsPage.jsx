import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { default as OwnerFlightsContainer } from "../../components/flights/owner/FlightsContainer";
import { default as ManagerFlightsContainer } from "../../components/flights/manager/FlightsContainer";
import { AppContext } from "../../App";
import { flights } from "../../rbac-consts";
import NotFoundPage from "../notFound/NotFoundPage";
import CabinetDefaultContainer from "../../components/elemets/cabinet/CabinetDefaultContainer";
import ToolbarRoleSwitch from "../../components/elemets/cabinet/toolbars/ToolbarRoleSwitch";

const FlightsPage = () => {

  return (
    <>
      <CabinetDefaultContainer
        Sidebar={<ToolbarRoleSwitch />}
        Content={<ContentRoleSwitch />}
      />
    </>
  );
};

const ContentRoleSwitch = () => {
  const { user } = useContext(AppContext);

  if (!user) {
    return <NotFoundPage />;
  }

  return (
    <>
      <Can
        role={user.roles}
        perform={flights.OWNER}
        yes={() => <OwnerFlightsContainer />}
      />
      <Can
        role={user.roles}
        perform={flights.MANAGER}
        yes={() => <ManagerFlightsContainer />}
      />
    </>
  );
};

export default FlightsPage;