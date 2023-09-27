import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { AppContext } from "../../App";
import { aircrafts } from "../../rbac-consts";
import NotFoundPage from "../notFound/NotFoundPage";
import CabinetDefaultContainer from "../../components/elemets/cabinet/CabinetDefaultContainer";
import ToolbarRoleSwitch from "../../components/elemets/cabinet/toolbars/ToolbarRoleSwitch";
import AircraftsEditContainer from "../../components/aircraftsEdit/owner/AircraftsEditContainer";

const AircraftsEditPage = () => {

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
        perform={aircrafts.OWNER}
        yes={() => <AircraftsEditContainer />}
      />
    </>
  );
};

export default AircraftsEditPage;