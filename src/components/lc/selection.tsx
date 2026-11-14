import { createContext, useContext, useMemo, useState, type ReactNode } from "react";

export type Track = "clinic" | "rvaas";

interface SelectionState {
  track: Track;
  setTrack: (t: Track) => void;
  clinicPackage: string;
  setClinicPackage: (id: string) => void;
  rvaasPackage: string;
  setRvaasPackage: (id: string) => void;
}

const SelectionContext = createContext<SelectionState | null>(null);

/**
 * Page-level state shared by the track selector, both pricing grids and the
 * final CTA. In Elementor this becomes a tiny vanilla JS store on window.
 */
export function SelectionProvider({ children }: { children: ReactNode }) {
  const [track, setTrack] = useState<Track>("clinic");
  const [clinicPackage, setClinicPackage] = useState("weekly");
  const [rvaasPackage, setRvaasPackage] = useState("two-papers");
  const value = useMemo(
    () => ({ track, setTrack, clinicPackage, setClinicPackage, rvaasPackage, setRvaasPackage }),
    [track, clinicPackage, rvaasPackage],
  );
  return <SelectionContext.Provider value={value}>{children}</SelectionContext.Provider>;
}

export function useSelection() {
  const ctx = useContext(SelectionContext);
  if (!ctx) throw new Error("useSelection must be used inside <SelectionProvider>");
  return ctx;
}
