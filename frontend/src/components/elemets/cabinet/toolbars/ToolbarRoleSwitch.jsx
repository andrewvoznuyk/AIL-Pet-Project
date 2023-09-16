import * as React from "react";
import { useContext } from "react";
import { AppContext } from "../../../../App";
import Can from "../../can/Can";
import { default as AdminToolbar } from "./admin/Toolbar";
import { default as OwnerToolbar } from "./owner/Toolbar";
import { default as ManagerToolbar } from "./manager/Toolbar";
import { default as UserToolbar } from "./user/Toolbar";
import { toolbar } from "../../../../rbac-consts";

const ToolbarRoleSwitch = () => {
  const { user } = useContext(AppContext);

  return <>
    <Can
      role={user.roles}
      perform={toolbar.ADMIN}
      yes={() => <AdminToolbar />}
    />
    <Can
      role={user.roles}
      perform={toolbar.OWNER}
      yes={() => <OwnerToolbar />}
    />
    <Can
      role={user.roles}
      perform={toolbar.MANAGER}
      yes={() => <ManagerToolbar />}
    />
    <Can
      role={user.roles}
      perform={toolbar.USER}
      yes={() => <UserToolbar />}
    />
  </>;
};

export default ToolbarRoleSwitch;