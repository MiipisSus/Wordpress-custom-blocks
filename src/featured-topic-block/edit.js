import { __ } from "@wordpress/i18n";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, RangeControl } from "@wordpress/components";
import "./editor.scss";

export default function Edit({
	attributes: { featuredTopicCount },
	setAttributes,
}) {
	return (
		<>
			<InspectorControls>
				<PanelBody title={__("Feature Topic Settings", "featured-topic-block")}>
					<RangeControl
						label={__("主題數量", "featured-topic-block")}
						value={featuredTopicCount}
						onChange={(value) =>
							setAttributes({ featuredTopicCount: parseInt(value, 10) })
						}
						min={1}
						max={10}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				<p>{__("精選主題資訊：", "featured-topic-block")}</p>
				<p>{featuredTopicCount}</p>
			</div>
		</>
	);
}
