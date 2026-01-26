import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	MediaUpload,
	MediaUploadCheck,
	URLInputButton,
} from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const {
		title,
		subtitle,
		description,
		imageUrl,
		linkUrl,
		linkText,
	} = attributes;

	const blockProps = useBlockProps({
		className: 'project-card',
	});

	const onSelectImage = (media) => {
		setAttributes({ imageUrl: media.url });
	};

	return (
		<div {...blockProps}>
			<MediaUploadCheck>
				<MediaUpload
					onSelect={onSelectImage}
					allowedTypes={['image']}
					render={({ open }) => (
						<Button
							onClick={open}
							className="project-card__image"
						>
							{imageUrl ? (
								<img src={imageUrl} alt="Project thumbnail" />
							) : (
								__('Upload Image', 'project-card')
							)}
						</Button>
					)}
				/>
			</MediaUploadCheck>

			<div className="project-card__content">
				<RichText
					tagName="h3"
					className="project-card__title"
					value={title}
					placeholder={__('Project Title', 'project-card')}
					onChange={(value) => setAttributes({ title: value })}
				/>

				<p className="project-card__subtitle">
					<RichText
						tagName="span"
						value={subtitle}
						placeholder={__('Subtitle or Tags', 'project-card')}
						onChange={(value) => setAttributes({ subtitle: value })}
					/>
				</p>

				<div className="project-card__description">
					<RichText
						multiline="p"
						value={description}
						placeholder={__('Project description...', 'project-card')}
						onChange={(value) => setAttributes({ description: value })}
					/>
				</div>

				<div className="project-card__link">
					<URLInputButton
						url={linkUrl}
						onChange={(url) => setAttributes({ linkUrl: url })}
					/>
					<RichText
						tagName="span"
						className="project-card__link-text"
						value={linkText}
						placeholder={__('Link text', 'project-card')}
						onChange={(value) => setAttributes({ linkText: value })}
					/>
				</div>
			</div>
		</div>
	);
}
