import { __ } from "@wordpress/i18n";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, RangeControl } from "@wordpress/components";
import "./editor.scss";

export default function Edit({
	attributes: { featuredTopicCount },
	setAttributes,
}) {
	function getChineseNumber(num) {
		const map = [
			"零",
			"一",
			"二",
			"三",
			"四",
			"五",
			"六",
			"七",
			"八",
			"九",
			"十",
		];
		if (num >= 1 && num <= 10) {
			return map[num];
		}
		return num;
	}

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
				<h1>{getChineseNumber(featuredTopicCount)}大看點</h1>
				<ul className="featured-topic-list">
					{Array.from({ length: featuredTopicCount }).map((_, i) => (
						<li className="featured-topic-item" key={i}>
							<span className="topic-index">{i + 1}</span>
							<span className="topic-title">主題標題 {i + 1}</span>
						</li>
					))}
				</ul>
			</div>
		</>
	);
}
