import { Eyebrow, Heading, Text } from "../atoms";
import { tracks as defaults } from "../content";
import { TrackCard } from "../molecules";
import { useSelection } from "../selection";

/** Section widget: "LC Service Toggle" — two selectable Track Cards. */
export function TrackSelector({ data = defaults }: { data?: typeof defaults | undefined }) {
  const { track, setTrack } = useSelection();
  return (
    <div className="lc-tracks">
      <div className="lc-tracks__head">
        <div className="lc-stack" style={{ ["--lc-stack-gap" as string]: "0.5rem" }}>
          <Eyebrow label={data.eyebrow} />
          <Heading text={data.title} level="h3" />
        </div>
        <Text size="small">{data.description}</Text>
      </div>
      <div className="lc-tracks__grid">
        {data.items.map(({ id, target, ...card }) => (
          <TrackCard
            key={id}
            {...card}
            selected={track === id}
            onSelect={() => {
              setTrack(id);
              document.querySelector(target)?.scrollIntoView({ behavior: "smooth" });
            }}
          />
        ))}
      </div>
    </div>
  );
}
