import React from "react";

export default function Default({children}: {
  children: React.ReactNode;
}) {
  return (
    <>
      <main>{children}</main>
    </>
  )
}
