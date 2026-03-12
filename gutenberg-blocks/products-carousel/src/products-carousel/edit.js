import { __ } from "@wordpress/i18n";

import { useEffect, useState } from "@wordpress/element";
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";

import {
	PanelBody,
	SelectControl,
	Placeholder,
	Spinner,
} from "@wordpress/components";
import apiFetch from "@wordpress/api-fetch";

import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
	const { targetGroup = "" } = attributes;
	const blockProps = useBlockProps();

	const [groups, setGroups] = useState([]);
	const [items, setItems] = useState([]);
	const [loading, setLoading] = useState(false);

	//Set the groups
	useEffect(() => {
		apiFetch({ path: "/products-carousel/v1/target-groups" })
			.then((response) => {
				setGroups(
					(response || []).map((term) => ({
						label: term.name,
						value: term.slug,
					})),
				);
			})
			.catch(() => {
				console.error("Error loading target groups:", error);
				setGroups([]);
			});
	}, []);

	//Set the items based on the Target
	useEffect(() => {
		console.log("Target group:", targetGroup);

		setLoading(true);
		const path = targetGroup
			? `/products-carousel/v1/items?target_group=${encodeURIComponent(
					targetGroup,
			  )}`
			: "/products-carousel/v1/items";

		apiFetch({ path })
			.then((response) => {
				console.log("Items response:", response);
				setItems(response || []);
			})
			.catch(() => {
				console.error("Items API error:", error);
				setItems([]);
			})
			.finally(() => {
				console.log("Loading finished");
				setLoading(false);
			});
	}, [targetGroup]);

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={__("Filter products", "products-carousel")}
					initialOpen={true}
				>
					<SelectControl
						label={__("Target groups", "products-carousel")}
						value={targetGroup}
						options={[
							{ label: __("All", "products-carousel"), value: "" },
							...groups,
						]}
						onChange={(value) => setAttributes({ targetGroup: value })}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="products-carousel-editor">
					<div className="products-carousel-editor__header">
						<strong>
							{__("Related products preview", "products-carousel")}
						</strong>
					</div>

					{loading ? (
						<Placeholder>
							<Spinner />
						</Placeholder>
					) : items.length > 0 ? (
						<div className="products-carousel-editor__grid">
							{items.map((item) => (
								<div className="products-carousel-editor__card" key={item.id}>
									{item.image ? (
										<img
											src={item.image}
											alt={item.title}
											className="products-carousel-editor__image"
										/>
									) : null}

									<div className="products-carousel-editor__content">
										<div className="products-carousel-editor__title">
											{item.title}
										</div>

										{item.price ? (
											<div className="products-carousel-editor__meta">
												<strong>Price:</strong> {item.price}
											</div>
										) : null}

										{item.cpu ? (
											<div className="products-carousel-editor__meta">
												<strong>CPU:</strong> {item.cpu}
											</div>
										) : null}

										{item.ram ? (
											<div className="products-carousel-editor__meta">
												<strong>RAM:</strong> {item.ram}
											</div>
										) : null}

										{item.ssd ? (
											<div className="products-carousel-editor__meta">
												<strong>SSD:</strong> {item.ssd}
											</div>
										) : null}

										{item.cta_label ? (
											<div className="products-carousel-editor__meta">
												<strong>CTA Label:</strong> {item.cta_label}
											</div>
										) : null}

										{item.cta_url ? (
											<div className="products-carousel-editor__meta">
												<strong>CTA URL:</strong> {item.cta_url}
											</div>
										) : null}

										{Array.isArray(item.features) &&
										item.features.length > 0 ? (
											<div className="products-carousel-editor__meta">
												<strong>Features:</strong>
												<ul className="products-carousel-editor__features">
													{item.features.map((feature, index) => (
														<li key={index}>{feature}</li>
													))}
												</ul>
											</div>
										) : null}

										{item.target_group ? (
											<div className="products-carousel-editor__meta">
												<strong>Target group:</strong> {item.target_group}
											</div>
										) : null}
									</div>
								</div>
							))}
						</div>
					) : (
						<Placeholder> no items found </Placeholder>
					)}
				</div>
			</div>
		</>
	);
}
