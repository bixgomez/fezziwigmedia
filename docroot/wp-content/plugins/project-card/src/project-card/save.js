import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const {
		imageUrl,
		title,
		subtitle,
		description,
		linkUrl,
		linkText,
	} = attributes;

	return (
		<div {...useBlockProps.save()} className="project-card">
			{imageUrl && (
				<div className="project-card__image">
					<img src={imageUrl} alt="" />
				</div>
			)}

			<div className="project-card__content">
				{title && (
					<RichText.Content
						tagName="h3"
						className="project-card__title"
						value={title}
					/>
				)}

				{subtitle && (
					<p className="project-card__subtitle">
						<RichText.Content
							tagName="span"
							value={subtitle}
						/>
					</p>
				)}

				{description && (
					<div className="project-card__description">
						<RichText.Content
							multiline="p"
							value={description}
						/>
					</div>
				)}

				{linkUrl && (
					<div className="project-card__link">
						<a href={linkUrl} className="project-card__link-text">
							{linkText || 'Learn More'}
						</a>
					</div>
				)}
			</div>
		</div>
	);
}
