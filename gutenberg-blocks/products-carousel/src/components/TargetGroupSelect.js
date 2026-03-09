import { __ } from "@wordpress/i18n";
import { useEffect, useState } from "@wordpress/element";
import { SelectControl } from "@wordpress/components";
import apiFetch from "@wordpress/api-fetch";

export default function TargetGroupSelect({ value, onChange }) {
	const [groups, setGroups] = useState([]);

	useEffect(() => {
		apiFetch({ path: "/products-carousel/v1/target-groups" })
			.then((terms) => {
				const options = terms.map((term) => ({
					label: term.name,
					value: term.slug,
				}));

				setGroups(options);
			})
			.catch(() => {
				setGroups([]);
			});
	}, []);

	return (
		<SelectControl
			label={__("Target group", "products-carousel")}
			value={value}
			options={[
				{ label: __("All", "products-carousel"), value: "" },
				...groups,
			]}
			onChange={onChange}
		/>
	);
}
